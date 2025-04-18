# Live House Event Manager

WordPress用ライブハウス・イベントスペース向けイベント管理プラグイン

## 概要

「Live House Event Manager」は、ライブハウスやイベントスペースがWordPressサイト上でイベント情報を効率的に管理し、訪問者に対して月間カレンダー形式およびリスト形式で分かりやすく表示することを目的としたプラグインです。

## 主な機能

- イベント（ライブ、コンサート等）の登録・編集・削除（カスタム投稿タイプ `live_event`）
- ジャンル管理（カスタムタクソノミー `event_genre`）
- 月間カレンダー表示（ショートコード `[livehouse_calendar]`）
- 月間リスト表示（ショートコード `[livehouse_event_list]`）
- AJAXによる月移動・モーダル表示
- イベント詳細ページの自動生成

## インストール方法

1. プラグインファイル一式を `wp-content/plugins/livehouse-event-manager` ディレクトリに配置
2. WordPress管理画面から「プラグイン」→「Live House Event Manager」を有効化

## 使い方

### イベントの登録
- 管理画面の「イベント」メニューから新規イベントを追加
- 開催日、開演時間、出演者、チケット情報などを入力

### カレンダー/リスト表示
- 固定ページや投稿に以下のショートコードを挿入
  - カレンダー: `[livehouse_calendar]`
  - リスト: `[livehouse_event_list]`

## ライセンス

MIT License

## 開発・要件定義

- バージョン: 1.0
- 最終更新日: 2025年4月15日
- 詳細は「プラグイン要件定義書」を参照
