# 仕様書

## shifty
同時記録型シフト管理アプリ「shifty」です。
カレンダーをチーム全員で共通管理することでシフトの調整が楽になることがメインコンセプトになります。

## 対象OSおよびブラウザ
Windows11動作確認済み<br>
macOS12.63動作確認済み<br>
Safari16.3動作確認済み<br>
google Chromeバージョン: 111.0.5563.146動作確認済み

## 開発環境/使用技術
開発環境：MAMP6.8<br>
使用技術：PHP v8.2.3 , JavaScript v18.14.2 , Laravel , Laravel Jetstream , FullCalendar

## 本番環境
エックスサーバーにSSH接続してデプロイ済み

## ER図
![スクリーンショット 2023-04-01 16 26 31](https://user-images.githubusercontent.com/115349126/229272148-79ac87bc-8106-486b-8f54-ec05305b67fd.png)

## 機能概要
チーム作成機能：Laravel Jetstreamを使用して新規チームを作成できる。メンバーの招待やチーム概要の編集も行える。<br>
ユーザー登録機能：Laravel Jetstreamを使用して新規ユーザーの登録や編集ができる。<br>
シフト追加機能：FullCalendarを使用してシフトの登録や編集ができる。確定したシフトはDBに保存される。また、チームに参加中のメンバーにのみシフトが自動で共有される

## コンセプト

従来のシフト管理アプリは、スタッフが各々のカレンダー画面からシフトを提出して責任者がその情報をまとめて最終的なシフトを完成させるという方法を採用しています。しかし、「shifty」ではスタッフ全員に共通のカレンダーを与え、そこに一斉にシフトを書き込んでもらうという方法を採用しているため、シフトの面倒な再調整や極端な人員の偏りが起こりにくいという状況が期待できます。

## こだわったポイント

マウスのドラッグ&ドロップ操作でシフトを直感的に操作できることにこだわりました。入力フォームを設ける必要がないので見た目も良くなるという効果がありました。全員のシフトの入力状況が即座にリアルタイムで更新され全員が確認できるようにこだわりました。

## デザイン面でこだわったポイント

カレンダーの表示です。月間カレンダーを表示させずに週間と日間カレンダーだけを設置したことで、画面の情報量を減らすことができました。
ユーザーはログイン後すぐにカレンダーが大きく画面に表示されるので、ログイン後の導線が明確になるように工夫しました


## 操作方法

[shifty](https://shifty.udonrm.com)に会員登録後、ヘッダーメニューから新規チームの作成をしたのちにカレンダーからシフトの登録を行なってください。
シフトの登録はマウスのドラッグ＆ドロップで追加、加工ができます。

## 動作デモ

### ログイン画面から基本操作まで
ログイン後からシフトの入力、シフトの確認までの動作イメージです。

直感的なドラッグ＆ドロップ操作でシフトを簡単に追加、編集することができます。

機能も最小限まで絞ったため、誰でも簡単に使えるアプリになっています。

https://user-images.githubusercontent.com/115349126/228453861-672d6502-6ce8-4c6d-b083-facd9b4e4cf4.mp4

### チームで運用する場合の動作イメージ
実際にチームの複数人でアプリを運用する場面を想定した動画です。

左画面がユーザー1で右画面がユーザー2の操作画面です。

全員のシフトの入力状況が即座にリアルタイムで更新され全員が確認できるようにこだわりました。

自分のシフトはオレンジ色で目立たせ、他の人のシフトと区別しやすいように設定しています。当然ですが、他のスタッフのシフトは勝手に編集できないように設計しました。

このようにシフト提出を管理することで、人の足りていない時間帯や人の多すぎる時間帯が全員に共有される（管理者が知らせる必要がない）ため効率的なシフトが組まれることが期待できます。

https://user-images.githubusercontent.com/115349126/228453922-ee6590b8-7d70-4cfe-8525-61697c444609.mp4

## 自己評価

初めの用件定義が甘く、データベースの設計も明確に定義できていなかった部分もあったため、途中でデータベースとの接続等に苦労した場面がありました。今後個人開発をする上では、細かく用件定義をして進めていきたいと思います。
また、Laravelを使用しての開発を通してフレームワークの使い方やMVCモデルの考え方を学べたのでいい経験になったと思います。初めての開発経験でしたが、エラーを乗り越えながらデプロイまで辿り着けたことも自信になりました。
