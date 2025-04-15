# Live House Event Manager

![バージョン](https://img.shields.io/badge/version-1.0-blue)
![WordPressバージョン](https://img.shields.io/badge/WordPress-6.0%2B-green)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple)

ライブハウスやイベントスペースのための、使いやすいWordPressイベント管理プラグイン。月間カレンダーとリスト表示機能を備え、訪問者にイベント情報を効率的に提供します。

## 主な機能

- 📅 **月間カレンダー表示** - イベントをビジュアルなカレンダー形式で表示
- 📋 **月間リスト表示** - イベントを日付順のリストで表示
- 🎸 **イベント管理** - 専用の投稿タイプでイベント情報を簡単に管理
- 🏷️ **ジャンル分類** - イベントをジャンル別にカテゴライズ
- 🔄 **AJAXナビゲーション** - ページリロードなしでカレンダー・リストを切り替え
- 🖼️ **イベント詳細表示** - 視覚的で情報量豊富なイベント詳細ページ

## インストール方法

1. このリポジトリのZIPファイルをダウンロードします
2. WordPressの管理画面から「プラグイン」>「新規追加」>「プラグインのアップロード」を選択
3. ダウンロードしたZIPファイルをアップロードしてインストール
4. プラグインを有効化

## 使い方

### イベントの追加・編集

1. 管理画面の「イベント」メニューから「新規追加」をクリック
2. イベント情報を入力
   - イベントタイトル
   - イベント詳細・説明文
   - イベント開催日
   - 開演時間・開場時間
   - 出演者情報
   - チケット料金・予約URL
   - 配信情報（任意）
   - アイキャッチ画像
   - ジャンル
3. 「公開」または「更新」ボタンをクリック

### ジャンルの管理

1. 「イベント」>「ジャンル」メニューから管理
2. ジャンル名・スラッグを設定して追加・編集・削除が可能

### フロントエンド表示

任意のページや投稿に以下のショートコードを配置:

```
[livehouse_calendar]  // 月間カレンダー表示
[livehouse_event_list]  // 月間リスト表示
```

## データモデル

### カスタム投稿タイプ
- `live_event` - イベント情報を管理

### カスタムタクソノミー
- `event_genre` - イベントのジャンル分類

### カスタムフィールド
- `_event_date` - 開催日
- `_start_time` - 開演時間
- `_doors_open_time` - 開場時間
- `_performers` - 出演者
- `_ticket_price` - チケット料金
- `_ticket_link` - チケットURL
- `_streaming_info` - 配信情報

## 技術仕様

- WordPressの標準関数を使用したプラグイン実装
- カスタム投稿タイプ・タクソノミー・メタボックスの活用
- ショートコードによるフロントエンド表示
- AJAXによる月間ナビゲーション
- モーダルウィンドウによるイベント簡易情報表示

## 動作要件

- WordPress 6.0以上
- PHP 7.4以上
- モダンブラウザ（Chrome、Firefox、Safari、Edge最新版）

## 今後の開発予定

- 繰り返しイベント（週次・月次）の登録機能
- ジャンル別フィルタリング機能
- 複数会場の管理機能
- フロントエンドでの検索・絞り込み機能
- チケット販売システム連携機能

## 貢献について

バグ報告や機能要望は、GitHubの[Issue](https://github.com/20m61/livehouse-event-manager/issues)にてお知らせください。

プルリクエストは大歓迎です！コードはWordPressのコーディング規約に準拠するようお願いします。

## ライセンス

このプラグインは[GPLv2](LICENSE)またはそれ以降のバージョンのもとで公開されています。

## 開発者

- [開発者名](https://github.com/20m61)

---

&copy; 2025 Live House Event Manager