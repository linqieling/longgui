<?php
return array(
    'name' => '在线留言',
    'addon' => 'liuYanBan',
    'desc' => '一款微信移动端在线留言及后台回复的功能应用。',
    'version' => '1.0',
    'author' => 'Lance',
    'logo' => 'logo.png',
    'entry_url' => 'liuYanBan/msg/index',
    'install_sql' => 'install.sql',
    'upgrade_sql' => '',
    'menu' => [
        [
            'name' => '留言列表',
            'url' => 'liuYanBan/Admin/index',
            'icon' => ''
        ]
    ],
    'config' => array(
        [
            'name' => 'title',
            'title' => '标题名称',
            'type' => 'text',
            'value' => '',
            'placeholder' => '请输入网站标题',
            'tip' => '留言板标题名称',
        ],
        [
            'name' => 'banner',
            'title' => 'banner图',
            'type' => 'image',
            'value' => '',
            'placeholder' => '',
            'tip' => '留言页的广告图，建议宽高480*320、大小200kb以下。',
        ],
        [
            'name' => 'number',
            'title' => '留言限制',
            'type' => 'text',
            'value' => '',
            'placeholder' => '不填默认为0，0则不限制',
            'tip' => '每人每天可留言次数。',
        ],
        [
            'name' => 'color',
            'title' => '颜色风格',
            'type' => 'text',
            'value' => '#52c41a',
            'placeholder' => '',
            'tip' => '界面风格颜色。',
        ]
    )
);