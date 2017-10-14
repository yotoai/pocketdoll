<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute must be accepted.',
    'active_url' => ':attribute is not a valid URL.',
    'after' => ':attribute must be a date after :date.',
    'alpha' => ':attribute may only contain letters.',
    'alpha_dash' => ':attribute may only contain letters, numbers, and dashes.',
    'alpha_num' => ':attribute 只能是字符与数字.',
    'array' => ':attribute必须为数组',
    'before' => ':attribute must be a date before :date.',
    'between' => [
        'numeric' => ':attribute must be between :min and :max.',
        'file' => ':attribute must be between :min and :max kilobytes.',
        'string' => ':attribute must be between :min and :max characters.',
        'array' => ':attribute must have between :min and :max items.',
    ],
    'boolean' => ':attribute field must be true or false.',
    'confirmed' => ':attribute两次输入不一致',
    'date' => ':attribute 日期格式不正确',
    'date_format' => ':attribute does not match the format :format.',
    'different' => ':attribute and :other must be different.',
    'digits' => ':attribute must be :digits digits.',
    'digits_between' => ':attribute must be between :min and :max digits.',
    'dimensions' => ':attribute has invalid image dimensions.',
    'distinct' => ':attribute不能重复',
    'email' => ':attribute格式不正确',
    'exists' => 'The selected :attribute is invalid.',
    'file' => ':attribute must be a file.',
    'filled' => ':attribute field is required.',
    'image' => ':attribute 必须是图片.',
    'in' => ':attribute 值必须在给定的 :values中',
    'in_array' => ':attribute field does not exist in :other.',
    'integer' => ':attribute必须为整数',
    'ip' => ':attribute 必须是有效的IP 地址.',
    'json' => ':attribute must be a valid JSON string.',
    'max' => [
        'numeric' => ':attribute may not be greater than :max.',
        'file' => ':attribute may not be greater than :max kilobytes.',
        'string' => ':attribute may not be greater than :max characters.',
        'array' => ':attribute may not have more than :max items.',
    ],
    'mimes' => ':attribute 文件类型必须是: :values.',
    'mimetypes' => ':attribute must be a file of type: :values.',
    'min' => [
        'numeric' => ':attribute不能少于 :min.',
        'file' => ':attribute不能少于 :min kilobytes.',
        'string' => ':attribute不能少于:min位',
        'array' => ':attribute must have at least :min items.',
    ],
    'not_in' => ':attribute 不能为 :values.',
    'numeric' => ':attribute 必须是数字！',
    'present' => ':attribute field must be present.',
    'regex' => ':attribute格式不正确.',
    'required' => ':attribute不能为空',
    'required_if' => ':attribute必须当:other为:value时',
    'required_unless' => ':attribute field is required unless :other is in :values.',
    'required_with' => ':attribute当:values存在时必须.',
    'required_with_all' => ':attribute field is required when :values is present.',
    'required_without' => ':attribute field is required when :values is not present.',
    'required_without_all' => ':attribute field is required when none of :values are present.',
    'same' => ':attribute and :other must match.',
    'size' => [
        'numeric' => ':attribute must be :size.',
        'file' => ':attribute must be :size kilobytes.',
        'string' => ':attribute must be :size characters.',
        'array' => ':attribute must contain :size items.',
    ],
    'string' => ':attribute必须为字符串',
    'timezone' => ':attribute must be a valid zone.',
    'unique' => ':attribute已经被使用',
    'uploaded' => ':attribute failed to upload.',
    'url' => ':attribute format is invalid.',
    'sms_code' => "手机验证码不正确",
    'old_sms_code' => "原手机验证码不正确",
    'mobile' => '手机格式不正确',
    'captcha' => '验证码不正确',
    'domain' => '域名格式不正确',
    'source_ip' => 'IP格式不正确',
    'port' => ':attribute 必须为1至65535内的整数',
    'line' => '线路错误',
    'article_parent_cate' => '该类名已经存在',
    'article_child_cate' => '该类名已经存在',
    'text_line' => '行数不能超过:values行',
    'array_ip' => '回源IP格式错误或数量超过5个',
    'monitor_url_type' => '该类型的主机已存在',
    'monitor_url_update' => '该类型的主机已存在',
    'mail_or_mobile' => '邮箱或手机号码格式错误',
    'strip_tags' => '包含敏感字符',
    'string_ip' => 'IP格式错误',
    'rule_source_ip' => 'IP格式错误或超过20条',
    'operator' => '操作人',
    'result' => '结果',
    'time' => '时间',
    'openssl_x509_base64' => '证书文件非法',
    'openssl_pkey_base64' => '证书KEY非法',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */


    'attributes' => [
        'email' => "邮箱",
        "password" => "密码",
        "old_password" => "原密码",
        "mobile" => "手机",
        "old_mobile" => "原手机",
        "mobileCaptcha" => "手机验证码",
        "old_mobileCaptcha" => "原手机验证码",
        'captcha' => "验证码",
        'domain' => '域名',
        'ruleName' => '规则名',
        'name' => '名称',
        'category.*.order_type' => '订单类型',
        'category.*.duration_type' => '时间类型',
        'category.*.duration' => '时长',
        'category.*.product_id' => '套餐ID',
        'category.*.product_type' => '套餐类型',
        'category.*.instance_id' => '实例ID',
        'sourcePort' => '源端口',
        'natPort' => '转发端口',
        'order_type' => '订单类型',
        'duration_type' => '时间类型',
        'duration' => '时长',
        'product_type' => '套餐类型',
        'product_id' => '套餐ID',
        'instance_id' => '实例ID',
        'rules' => '规则',
        'rules.*.ip' => 'IP',
        'rules.*.port' => '高防端口',
        'rules.*.protocol' => '协议',
        'rules.*.s_ip' => '源IP',
        'rules.*.s_port' => '源端口',
        'num' => '数量',
        'region' => '地域',
        'isp' => '供应商',
        'udp_flag' => 'UDP压制',
        'oversea_flag' => '海外压制',
        'ip_list' => 'IP列表',
        'ip_list.*.ip' => 'IP',
        'ip_list.*.block_flux' => '阈值',
        'ips' => 'IP列表',
        'type' => '类型',
        'cert_type' => '证件类型',
        'cert_number' => '证件号码',
        'province' => '省份',
        'city' => '市',
        'address' => '地址',
        'attachment' => '附件',
        'attachment.*' => '附件',
        'real_name' => '真是姓名',
        'company_name' => '企业名称',
        'company_cert_type' => '企业证件类型',
        'company_cert_number' => '企业证件号码',
        'company_contact' => '联系人',
        'other_cert_type' => '其他可选类型证件',
        'other_attachment' => '其他可选类型附件',
        'starttime' => '起始时间',
        'endtime' => '结束时间',
        'period' => '时间粒度',
        'taskid' => '任务ID',
        'host' => '域名',
        'sync' => '同步',
        'rules.*.host' => '域名',
        'rules.*.sources' => '源站域名或IP',
        'rules.*.region' => '地区',
        'rules.*.cert' => '证书',
        'rules.*.private_key' => '私钥',
        'rules.*.source_type' => '回源类型',
        'limit' => '转发带宽',
        'protocol' => '协议',
        'cert' => '证书',
        'private_key' => '私钥',
        'source_type' => '回源类型',
        'sources' => '源站域名或IP',
    ],

];
