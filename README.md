# Live House Event Manager

![バージョン](https://img.shields.io/badge/version-1.0-blue)
![WordPressバージョン](https://img.shields.io/badge/WordPress-6.0%2B-green)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple)

ライブハウスやイベントスペースのための、使いやすい WordPress イベント管理プラグイン。月間カレンダーとリスト表示機能を備え、訪問者にイベント情報を効率的に提供します。

## 主な機能

- 📅 **月間カレンダー表示** - イベントをビジュアルなカレンダー形式で表示
- 📋 **月間リスト表示** - イベントを日付順のリストで表示
- 🎸 **イベント管理** - 専用の投稿タイプでイベント情報を簡単に管理
- 🏷️ **ジャンル分類** - イベントをジャンル別にカテゴライズ
- 🔄 **AJAX ナビゲーション** - ページリロードなしでカレンダー・リストを切り替え
- 🖼️ **イベント詳細表示** - 視覚的で情報量豊富なイベント詳細ページ

## インストール方法

1. このリポジトリの ZIP ファイルをダウンロード
2. WordPress 管理画面で「プラグイン」>「新規追加」>「プラグインのアップロード」を選択
3. ZIP ファイルをアップロードしてインストール
4. プラグインを有効化

## 使い方

### イベントの追加・編集

1. 管理画面の「イベント」>「新規追加」をクリック
2. イベント情報を入力
   - イベントタイトル
   - イベント詳細・説明文
   - 開催日、開演時間・開場時間
   - 出演者情報
   - チケット料金・予約 URL
   - 配信情報（任意）
   - アイキャッチ画像
   - ジャンル
3. 「公開」または「更新」をクリック

### ジャンルの管理

1. 「イベント」>「ジャンル」から管理
2. ジャンル名・スラッグを設定し追加・編集・削除

### フロントエンド表示

以下のショートコードを任意のページや投稿に配置:

- カレンダー: `[livehouse_calendar]`
- リスト: `[livehouse_event_list]`

### ショートコード

- `[livehouse_event_list]`  
  月間リスト表示。選択セレクトで当月イベントを AJAX 更新。

- `[livehouse_calendar]`  
  月間カレンダー表示。←/→ ボタンで前後月切り替え、イベントリンク付き。

### アセット

プラグイン有効化後、以下ファイルが自動で読み込まれます。

- assets/css/style.css
- assets/css/calendar.css
- assets/js/filter.js
- assets/js/calendar.js

## テスト

開発環境で以下を実行してください:

```bash
composer install
npm install # （必要に応じて）
composer test
```

## Issue の報告・提案

バグ報告や機能要望は、以下のテンプレートを使用して GitHub Issues にて投稿してください:

- バグ報告: `.github/ISSUE_TEMPLATE/bug_report.md`
- 機能要望: `.github/ISSUE_TEMPLATE/feature_request.md`

## ライセンス

MIT License

## 開発・要件定義

- バージョン: 1.0
- 最終更新日: 2025 年 4 月 15 日
- 詳細は「プラグイン要件定義書」[docs/plugin-requirements.md](docs/plugin-requirements.md)を参照
