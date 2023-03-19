import { Calendar } from "@fullcalendar/core";
import interactionPlugin, { Draggable } from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import axios from "axios";
import "./calendar";

var calendarEl = document.getElementById("calendar");

let calendar = new Calendar(calendarEl, {
    locale: "ja",
    plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin],
    initialView: "timeGridWeek",
    navLinks: true,
    selectable: true,
    editable: true,
    noEventsContent: "提出されたシフトはありません",

    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "timeGridWeek,timeGridDay,listWeek",
    },

    buttonText: {
        today: "今日",
        week: "週",
        day: "日",
        list: "シフト",
    },

    allDayText: "終日",

    select: function (arg) {
        axios
            .post("/schedule-add", {
                start_date: arg.start.valueOf(),
                end_date: arg.end.valueOf(),
                user_id: userid,
                team_id: currentTeamId,
            })
            .then((response) => {
                calendar.addEvent({
                    id: response.data.id,
                    title: username,
                    start: arg.start,
                    end: arg.end,
                    allDay: arg.allDay,
                    color: "#FFA500",
                    extendedProps: {
                        user_id: userid, // ここでuser_idをextendedPropsに追加
                    },
                });
            })
            .catch(() => {
                // バリデーションエラーなど
                alert("登録に失敗しました");
            });
    },

    eventClick: function (arg) {
        if (arg.event.extendedProps.user_id == userid) {
            if (confirm("シフトを削除しますか？")) {
                axios
                    .post("/schedule-destroy", {
                        id: arg.event.id,
                    })
                    .then(() => {
                        arg.event.remove();
                    })
                    .catch(() => {
                        alert("削除に失敗しました");
                    });
            }
        } else {
            alert("他のユーザーのシフトは編集できません");
        }
    },

    eventDrop: function (arg) {
        if (arg.event.extendedProps.user_id == userid) {
            axios
                .post("/schedule-update", {
                    id: arg.event.id,
                    start_date: arg.event.start.valueOf(),
                    end_date: arg.event.end.valueOf(),
                    team_id: currentTeamId,
                })
                .catch(() => {
                    // バリデーションエラーなど
                    alert("更新に失敗しました");
                    arg.revert();
                });
        } else {
            alert("他のユーザーのシフトは編集できません");
            arg.revert();
        }
    },

    eventResize: function (arg) {
        if (arg.event.extendedProps.user_id == userid) {
            axios
                .post("/schedule-update", {
                    id: arg.event.id,
                    start_date: arg.event.start.valueOf(),
                    end_date: arg.event.end.valueOf(),
                    team_id: currentTeamId,
                })
                .catch(() => {
                    // バリデーションエラーなど
                    alert("更新に失敗しました");
                    arg.revert();
                });
        } else {
            alert("他のユーザーのシフトは編集できません");
            arg.revert();
        }
    },
});

calendar.render();
(async function fetchInitialEvents() {
    const start = calendar.view.activeStart; //カレンダーの範囲全部
    const end = calendar.view.activeEnd;

    try {
        const response = await axios.post("/schedule-get", {
            start_date: start.valueOf(),
            end_date: end.valueOf(),
            team_id: currentTeamId,
        });

        response.data.forEach((eventData) => {
            calendar.addEvent({
                id: eventData.id,
                start: eventData.start,
                end: eventData.end,
                title: eventData.username,
                user_id: eventData.user_id,
                color: eventData.user_id == userid ? "#FFA500" : "#429AA7", // ここでカラーを決定
            });
        });
    } catch (error) {
        console.error("Error fetching initial events:", error);
    }
})();
