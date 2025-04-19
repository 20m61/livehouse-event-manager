# プラグイン要件定義書: Live House Event Manager

**バージョン:** 1.0  
**作成日:** 2025 年 4 月 15 日  
**最終更新日:** 2025 年 4 月 15 日

## 1. 概要

本プラグイン「Live House Event Manager」は、ライブハウスやイベントスペースが WordPress サイト上でイベント情報を効率的に管理し、訪問者に対して月間カレンダー形式およびリスト形式で表示することを目的とする。

## 2. コアコンセプト

- **イベント (Event):** ライブ、コンサート、トークショーなど。開催日時、出演者、詳細情報、チケット情報を持つ。

## 3. 機能要件

### 3.1 管理画面 (バックエンド)

- **3.1.1 イベント管理 (CPT: `live_event`)**

  - メニュー「イベント」を追加
  - フィールド: タイトル、本文、開催日、開演/開場時間、アイキャッチ画像、出演者、料金、チケット URL、配信情報、ジャンル

- **3.1.2 ジャンル管理 (Taxonomy: `event_genre`)**
  - 「イベント > ジャンル」を追加
  - タグ形式で複数選択可

### 3.2 フロントエンド表示

- **3.2.1 月間カレンダー (`[livehouse_calendar]`)**

  - カレンダーグリッド生成
  - 日付セルにイベントタイトル＋サムネイルを表示
  - モーダルポップアップで簡易情報
  - 前後月切替は AJAX

- **3.2.2 月間リスト (`[livehouse_event_list]`)**

  - 日付順リスト表示
  - 日時、タイトル、出演者、サムネイル、詳細リンク
  - AJAX で前後月切替

- **3.2.3 イベント詳細ページ**
  - `single-live_event.php` で詳細表示
  - 登録項目すべてを表示

## 4. データモデル

- **CPT:** `live_event` (supports: title, editor, thumbnail, custom-fields, archive)
- **Taxonomy:** `event_genre` (非階層, `live_event` に紐付け)
- **Post Meta:**
  - `_event_date` (YYYY-MM-DD)
  - `_start_time`, `_doors_open_time` (HH:MM)
  - `_performers`, `_ticket_price`, `_ticket_link`, `_streaming_info`

## 5. 非機能要件

- パフォーマンス: AJAX 切替でスムーズ
- 互換性: 最新 WP & 標準テーマ対応
- コーディング規約準拠

## 6. 技術的実装方針

- `register_post_type`、`register_taxonomy`、`add_meta_box`等を利用
- `add_shortcode`でショートコード定義
- `WP_Query` + `meta_query`で月別取得
- AJAX は `wp_ajax_*` / `wp_ajax_nopriv_*`
- CSS/JS は `wp_enqueue_*`で読み込み

## 7. スコープ外

- 定期イベント登録
- 高度検索・絞り込み機能
- 複数会場管理
- チケット販売連携
- ユーザー投稿機能
