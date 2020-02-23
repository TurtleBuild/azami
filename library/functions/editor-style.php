<?php
/*-------------------------------------------------
クラシックエディタのスタイル定義
-------------------------------------------------*/
function azami_editor_setting($init)
{
  // h1は記事本文では使用しないため選択肢から削除
  $init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Preformatted=pre';

  /*
  文字のスタイル
  -------------------------------------------------*/
  $style_formats_typography = array(
    'title' => '文字のスタイル',
    'items' => array(
      array(
        'title' => '小さめの文字',
        'inline' => 'span',
        'classes' => 'small',
      ),
      array(
        'title' => '大きめの文字',
        'inline' => 'span',
        'classes' => 'text--large',
      ),
      array(
        'title' => '文字（赤）',
        'inline' => 'span',
        'classes' => 'text--red',
      ),
      array(
        'title' => '文字（緑）',
        'inline' => 'span',
        'classes' => 'text--green',
      ),
      array(
        'title' => '文字（青）',
        'inline' => 'span',
        'classes' => 'text--blue',
      ),
      array(
        'title' => 'マーカー（ピンク）',
        'inline' => 'span',
        'classes' => 'marker--pink',
      ),
      array(
        'title' => 'マーカー（緑）',
        'inline' => 'span',
        'classes' => 'marker--green',
      ),
      array(
        'title' => 'マーカー（青）',
        'inline' => 'span',
        'classes' => 'marker--blue',
      ),
    )
  );

  /*
  見出しのスタイル
  -------------------------------------------------*/
  $style_formats_headlines = array(
    'title' => '見出しのスタイル',
    'items' => array(
      array(
        'title' => '下線',
        'block' => 'p',
        'classes' => 'azami-heading h-border',
      ),
      array(
        'title' => '色が変わる下線',
        'block' => 'p',
        'classes' => 'azami-heading h-bdr-b--changed',
      ),
      array(
        'title' => '左線',
        'block' => 'p',
        'classes' => 'azami-heading h-border--left',
      ),
      array(
        'title' => '色が変わる左線',
        'block' => 'p',
        'classes' => 'azami-heading h-bdr-l--changed',
      ),
      array(
        'title' => '上下線',
        'block' => 'p',
        'classes' => 'azami-heading h-border--topbot',
      ),
      array(
        'title' => '二重下線',
        'block' => 'p',
        'classes' => 'azami-heading h-border--double',
      ),
      array(
        'title' => '点線下線',
        'block' => 'p',
        'classes' => 'azami-heading h-border--dashed',
      ),
      array(
        'title' => '縞模様の下線',
        'block' => 'p',
        'classes' => 'azami-heading h-stripe',
      ),
    )
  );
  
  /*
  ボックスのスタイル
  -------------------------------------------------*/
  $style_formats_boxes = array(
    'title' => 'ボックスのスタイル',
    'items' => array(
      array(
        'title' => 'シンプルなボックス',
        'block' => 'div',
        'classes' => 'azami-box simple-box',
        'wrapper' => true,
      ),
      array(
        'title' => '囲み線無しボックス',
        'block' => 'div',
        'classes' => 'azami-box',
        'wrapper' => true,
      ),
      array(
        'title' => '上下線ボックス',
        'block' => 'div',
        'classes' => 'azami-box topbot-border-box',
        'wrapper' => true,
      ),
      array(
        'title' => '上線ボックス',
        'block' => 'div',
        'classes' => 'azami-box top-border-box',
        'wrapper' => true,
      ),
      array(
        'title' => '左線ボックス',
        'block' => 'div',
        'classes' => 'azami-box left-border-box',
        'wrapper' => true,
      ),
      array(
        'title' => '二重線ボックス',
        'block' => 'div',
        'classes' => 'azami-box double-border-box',
        'wrapper' => true,
      ),
      array(
        'title' => '点線ボックス',
        'block' => 'div',
        'classes' => 'azami-box dashed-border-box',
        'wrapper' => true,
      ),
    )
  );

  /*
  ボタンのスタイル
  -------------------------------------------------*/
  $style_formats_buttons = array(
    'title' => 'ボタンのスタイル',
    'items' => array(
      array(
        'title' => 'フラットなボタン',
        'selector' => 'a',
        'classes' => 'azami-button',
      ),
      array(
        'title' => '立体的なボタン',
        'selector' => 'a',
        'classes' => 'azami-button button--cubic',
      ),
      array(
        'title' => 'ピル型のボタン（フラット）',
        'selector' => 'a',
        'classes' => 'azami-button button--circle',
      ),
      array(
        'title' => 'ピル型のボタン（立体的）',
        'selector' => 'a',
        'classes' => 'azami-button button--circle button--cubic',
      ),
    )
  );

  $style_formats = array(
    $style_formats_typography,
    $style_formats_headlines,
    $style_formats_boxes,
    $style_formats_buttons
  );

  $init['style_formats'] = json_encode($style_formats);
  return $init;
}
add_filter('tiny_mce_before_init', 'azami_editor_setting');

function add_azami_style($buttons)
{
  array_splice($buttons, 1, 0, 'styleselect');
  return $buttons;
}
add_filter('mce_buttons', 'add_azami_style');
