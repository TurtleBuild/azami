<?php
// 外部のファイル，ライブラリ，フレームワークの読み込み
require_once 'library/functions/readfile.php';
// AZAMIの初期設定
require_once 'library/functions/initialize.php';
// AZAMIの機能定義
require_once 'library/functions/azami-functions.php';
// メタタグの制御
require_once 'library/functions/head.php';
// カスタマイザーの登録
require_once 'library/functions/customizer.php';
// カスタマイザースタイルの定義
require_once 'library/functions/customizer-style.php';
// クラシックエディタのスタイル定義
require_once 'library/functions/editor-style.php';


/*-------------------------------------------------
「AZAMI」テーマの更新通知
-------------------------------------------------*/
require 'library/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://raw.githubusercontent.com/TurtleBuild/azami/master/library/update-json/azami-update.json',
    __FILE__,
    'AZAMI'
);