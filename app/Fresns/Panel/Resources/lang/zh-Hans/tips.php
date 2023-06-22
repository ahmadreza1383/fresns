<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Fresns Panel Tips Language Lines
    |--------------------------------------------------------------------------
    */

    'createSuccess' => '创建成功',
    'deleteSuccess' => '删除成功',
    'updateSuccess' => '修改成功',
    'upgradeSuccess' => '更新成功',
    'installSuccess' => '安装成功',
    'uninstallSuccess' => '卸载成功',

    'createFailure' => '创建失败',
    'deleteFailure' => '删除失败',
    'updateFailure' => '修改失败',
    'upgradeFailure' => '更新失败',
    'installFailure' => '安装失败',
    'downloadFailure' => '下载失败',
    'uninstallFailure' => '卸载失败',

    'copySuccess' => '复制成功',
    'viewLog' => '执行遇到了问题，详细信息请查看 Fresns 系统日志',
    // auth empty
    'auth_empty_title' => '请使用正确的入口登录面板',
    'auth_empty_description' => '您已退出登录或者登录超时，请访问登录入口重新登录。',
    // request
    'request_in_progress' => '正在请求中...',
    'requestSuccess' => '请求成功',
    'requestFailure' => '请求失败',
    // install
    'install_not_entered_key' => '请输入标识名',
    'install_not_entered_directory' => '请输入目录',
    'install_not_upload_zip' => '请选择安装包',
    'install_in_progress' => '正在安装中...',
    'install_end' => '安装结束',
    // upgrade
    'upgrade_none' => '暂无更新',
    'upgrade_fresns' => '有新的 Fresns 版本可供升级。',
    'upgrade_fresns_tip' => '您可以升级到',
    'upgrade_fresns_warning' => '升级前请先备份数据库，避免升级不当导致数据丢失。',
    'upgrade_confirm_tip' => '确定升级吗？',
    'manual_upgrade_tip' => '本次升级不支持自动升级，请使用「手动升级」方法。',
    'manual_upgrade_version_guide' => '点击阅读本次版本更新说明',
    'manual_upgrade_guide' => '升级指南',
    'manual_upgrade_file_error' => '手动升级文件不匹配',
    'manual_upgrade_confirm_tip' => '请确认已经阅读了「升級指南」，并且按指南处理好了新版文件。',
    'upgrade_in_progress' => '正在更新中...',
    'auto_upgrade_step_1' => '初始化验证',
    'auto_upgrade_step_2' => '下载升级包',
    'auto_upgrade_step_3' => '解压升级包',
    'auto_upgrade_step_4' => '升级 Fresns',
    'auto_upgrade_step_5' => '清理缓存',
    'auto_upgrade_step_6' => '完成',
    'manual_upgrade_step_1' => '初始化验证',
    'manual_upgrade_step_2' => '更新数据',
    'manual_upgrade_step_3' => '安装所有插件依赖包（该步骤流程较慢，请耐心等待）',
    'manual_upgrade_step_4' => '发布并恢复扩展启用',
    'manual_upgrade_step_5' => '更新 Fresns 版本信息',
    'manual_upgrade_step_6' => '清理缓存',
    'manual_upgrade_step_7' => '完成',
    // uninstall
    'uninstall_in_progress' => '正在卸载中...',
    'uninstall_step_1' => '初始化验证',
    'uninstall_step_2' => '数据处理',
    'uninstall_step_3' => '删除文件',
    'uninstall_step_4' => '清理缓存',
    'uninstall_step_5' => '完成',
    // delete app
    'delete_app_warning' => '如果你不希望显示该应用的升级提醒，可以删除该应用。删除后，有新版本将不再提示。',
    // website
    'website_path_empty_error' => '保存失败，路径参数不允许为空',
    'website_path_format_error' => '保存失败，路径参数仅支持纯英文字母',
    'website_path_reserved_error' => '保存失败，路径参数含有系统保留参数名',
    'website_path_unique_error' => '保存失败，路径参数重复，路径参数名不允许彼此重复',
    // theme
    'theme_error' => '主题错误或者不存在',
    'theme_functions_file_error' => '主题配置的视图文件错误或者不存在',
    'theme_json_file_error' => '主题配置文件错误或者不存在',
    'theme_json_format_error' => '主题配置文件格式错误',
    // others
    'account_not_found' => '账号不存在或者输入错误',
    'account_login_limit' => '错误已超系统限制，请 1 小时后再登录',
    'timezone_error' => '数据库时区和 .env 配置文件中时区不一致',
    'timezone_env_edit_tip' => '请修改根目录 .env 配置文件中时区地名配置项',
    'secure_entry_route_conflicts' => '安全入口路由冲突',
    'language_exists' => '语言已存在',
    'language_not_exists' => '语言不存在',
    'plugin_not_exists' => '插件不存在',
    'map_exists' => '该地图服务商已被使用，不可重复创建',
    'map_not_exists' => '地图服务商不存在',
    'required_user_role_name' => '请填写角色名称',
    'required_sticker_category_name' => '请填写表情组名称',
    'required_group_category_name' => '请填写小组分类名称',
    'required_group_name' => '请填写小组名称',
    'delete_group_category_error' => '分类下存在小组，不允许删除',
    'delete_default_language_error' => '默认语言不能删除',
    'account_connect_services_error' => '第三方互联支持中有重复的互联平台',
    'post_datetime_select_error' => '帖子设置的日期范围不能为空',
    'post_datetime_select_range_error' => '帖子设置的结束日期不能小于开始日期',
    'comment_datetime_select_error' => '评论设置的日期范围不能为空',
    'comment_datetime_select_range_error' => '评论设置的结束日期不能小于开始日期',
];
