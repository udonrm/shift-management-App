<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\User;


class ScheduleController extends Controller
{
    /**
     * イベントを登録する
     *
     * @param Request $request
     * @return void
     */
    public function add(Request $request)
    {
        // バリデーション
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'user_id' => 'required',
            'team_id' => 'required',
        ]);

        // 登録処理
        $schedule = new Schedule;
        // 日付に変換。JavaScriptのタイムスタンプはミリ秒なので秒に変換
        $schedule->start_date = date('Y-m-d-H-i-s', $request->input('start_date') / 1000);
        $schedule->end_date = date('Y-m-d-H-i-s', $request->input('end_date') / 1000);
        $schedule->user_id = $request->input('user_id');
        $schedule->team_id = $request->input('team_id');
        $schedule->save();

        return response()->json(['id' => $schedule->id]);
    }

    /**
     * イベントを取得する
     *
     * @param Request $request
     * @return void
     */
    public function get(Request $request)
    {
        // バリデーション
        $request->validate([
            'start_date' => 'required|integer',
            'end_date' => 'required|integer',
            'team_id' => 'required|integer',
        ]);

        // カレンダー表示期間
        $start_date = date('Y-m-d-H-i-s', $request->input('start_date') / 1000);
        $end_date = date('Y-m-d-H-i-s', $request->input('end_date') / 1000);
        $team_id = $request->input('team_id');

        // 登録処理
        $events = Schedule::query()
            ->select(
                // FullCalendarの形式に合わせる
                'id',
                'start_date as start',
                'end_date as end',
                'user_id'
            )
            // FullCalendarの表示範囲のみ表示
            ->where('end_date', '>', $start_date)
            ->where('start_date', '<', $end_date)
            ->where('team_id', $team_id)
            ->get();

        // Fetch all users and add their names to the events
        $events->map(function ($event) {
            $user = User::find($event->user_id);
            $event->username = $user->name;
            $event->user_id = $user->id;
            return $event;
        });

        return $events;
    }

    /**
     * イベントを更新する
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        // バリデーション
        $request->validate([
            'id' => 'required|integer',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        // 更新処理
        $schedule = Schedule::findOrFail($request->input('id'));
        $schedule->start_date = date('Y-m-d H:i:s', $request->input('start_date') / 1000);
        $schedule->end_date = date('Y-m-d H:i:s', $request->input('end_date') / 1000);
        $schedule->save();

        return;
    }

    /**
     * イベントを削除する
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        // バリデーション
        $request->validate([
            'id' => 'required|integer',
        ]);

        // 削除処理
        $schedule = Schedule::findOrFail($request->input('id'));
        $schedule->delete();
        return;
    }
}
