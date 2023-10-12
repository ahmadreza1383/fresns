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

    'createSuccess' => 'सफलता बनाएँ',
    'deleteSuccess' => 'सफलता हटाएं',
    'updateSuccess' => 'अब तक की सफलता',
    'upgradeSuccess' => 'अपग्रेड सफलता',
    'installSuccess' => 'सफलता स्थापित करें',
    'uninstallSuccess' => 'सफलता की स्थापना रद्द करें',

    'createFailure' => 'विफलता बनाएँ',
    'deleteFailure' => 'विफलता हटाएं',
    'updateFailure' => 'अद्यतन विफलता',
    'upgradeFailure' => 'अपग्रेड विफलता',
    'installFailure' => 'स्थापना विफलता',
    'downloadFailure' => 'डाउनलोड विफलता',
    'uninstallFailure' => 'स्थापना रद्द करने में विफलता',

    'copySuccess' => 'सफलतापूर्वक कॉपी करें',
    'viewLog' => 'निष्पादन में कोई समस्या आई, कृपया विवरण के लिए फ़्रेस्न्स सिस्टम लॉग की जाँच करें',
    // auth empty
    'auth_empty_title' => 'कृपया पैनल में लॉग इन करने के लिए सही प्रविष्टि का उपयोग करें',
    'auth_empty_description' => 'आप लॉग आउट हो गए हैं या लॉगिन टाइम आउट हो गया है, कृपया फिर से लॉग इन करने के लिए लॉगिन पोर्टल पर जाएं।',
    // request
    'request_in_progress' => 'अनुरोध जारी है...',
    'requestSuccess' => 'अनुरोध सफलता',
    'requestFailure' => 'अनुरोध विफलता',
    // install
    'install_not_entered_key' => 'कृपया fresns कुंजी दर्ज करें',
    'install_not_entered_directory' => 'कृपया एक निर्देशिका दर्ज करें',
    'install_not_upload_zip' => 'कृपया स्थापना पैकेज का चयन करें',
    'install_in_progress' => 'इंस्टॉल हो रहा है...',
    'install_end' => 'स्थापना का अंत',
    // upgrade
    'upgrade_none' => 'कोई अपग्रेड नहीं',
    'upgrade_fresns' => 'अपग्रेड के लिए एक नया FRESNS संस्करण उपलब्ध है।',
    'upgrade_fresns_tip' => 'आप अपग्रेड कर सकते हैं',
    'upgrade_fresns_warning' => 'अनुचित अपग्रेड के कारण डेटा हानि से बचने के लिए कृपया अपग्रेड करने से पहले डेटाबेस का बैकअप लें।',
    'upgrade_confirm_tip' => 'अपग्रेड का निर्धारण करें?',
    'manual_upgrade_tip' => 'यह अपग्रेड स्वचालित अपग्रेड का समर्थन नहीं करता है, कृपया "भौतिक अपग्रेड" पद्धति का उपयोग करें।',
    'manual_upgrade_version_guide' => 'इस संस्करण का अद्यतन विवरण पढ़ने के लिए क्लिक करें',
    'manual_upgrade_guide' => 'अपग्रेड मार्गदर्शिका',
    'manual_upgrade_file_error' => 'भौतिक उन्नयन फ़ाइल बेमेल',
    'manual_upgrade_confirm_tip' => 'कृपया सुनिश्चित करें कि आपने "अपग्रेड मार्गदर्शिका" पढ़ ली है और मार्गदर्शिका के अनुसार फ़ाइल के नए संस्करण को संसाधित कर लिया है।',
    'upgrade_in_progress' => 'अपग्रेड जारी है...',
    'auto_upgrade_step_1' => 'प्रारंभिक सत्यापन',
    'auto_upgrade_step_2' => 'एप्लिकेशन पैकेज डाउनलोड करें',
    'auto_upgrade_step_3' => 'अनजिप आवेदन पैकेज',
    'auto_upgrade_step_4' => 'अपग्रेड आवेदन',
    'auto_upgrade_step_5' => 'गुप्त जगह खाली करें',
    'auto_upgrade_step_6' => 'समाप्त',
    'manualUpgrade_step_1' => 'प्रारंभिक सत्यापन',
    'manualUpgrade_step_2' => 'अद्यतन आकड़ें',
    'manualUpgrade_step_3' => 'सभी प्लगइन निर्भरता पैकेज स्थापित करें (यह कदम एक धीमी प्रक्रिया है, कृपया धैर्य रखें)',
    'manualUpgrade_step_4' => 'प्रकाशित करें और एक्सटेंशन पुनर्स्थापित करें सक्रिय करें',
    'manualUpgrade_step_5' => 'Fresns संस्करण जानकारी अपडेट करें',
    'manualUpgrade_step_6' => 'गुप्त जगह खाली करें',
    'manualUpgrade_step_7' => 'समाप्त',
    // uninstall
    'uninstall_in_progress' => 'अनइंस्टॉल चल रहा है...',
    'uninstall_step_1' => 'प्रारंभिक सत्यापन',
    'uninstall_step_2' => 'डाटा प्रासेसिंग',
    'uninstall_step_3' => 'फाइलों को नष्ट',
    'uninstall_step_4' => 'कैश को साफ़ करें',
    'uninstall_step_5' => 'पूर्ण',
    // delete app
    'delete_app_warning' => 'यदि आप ऐप का अपग्रेड रिमाइंडर नहीं देखना चाहते हैं, तो आप ऐप हटा सकते हैं। हटाने के बाद, नए संस्करण के लिए कोई संकेत नहीं दिया जाएगा.',
    // website
    'website_path_empty_error' => 'सहेजने में विफल, पथ पैरामीटर को खाली होने की अनुमति नहीं है',
    'website_path_format_error' => 'सहेजने में विफल, पथ पैरामीटर केवल शुद्ध अंग्रेजी अक्षरों का समर्थन करता है',
    'website_path_reserved_error' => 'सहेजने में विफल, पथ पैरामीटर में सिस्टम आरक्षित पैरामीटर नाम शामिल है',
    'website_path_unique_error' => 'सहेजने में विफल, डुप्लिकेट पथ पैरामीटर, पथ पैरामीटर नाम एक दूसरे को डुप्लिकेट करने की अनुमति नहीं है',
    // others
    'markdown_editor' => 'सामग्री मार्कडाउन सिंटैक्स का समर्थन करती है, लेकिन इनपुट बॉक्स पूर्वावलोकन का समर्थन नहीं करता है। कृपया इसे सहेजें और प्रभाव देखने के लिए क्लाइंट पर जाएं।',
    'account_not_found' => 'खाता मौजूद नहीं है या गलत तरीके से दर्ज किया गया है',
    'account_login_limit' => 'त्रुटि सिस्टम सीमा से अधिक हो गई है। कृपया 1 घंटे बाद फिर से लॉग इन करें',
    'timezone_error' => 'डेटाबेस टाइमज़ोन .env कॉन्फ़िग फ़ाइल में टाइमज़ोन से मेल नहीं खाता',
    'timezone_env_edit_tip' => 'कृपया .env फ़ाइल में टाइमज़ोन आइडेंटिफ़ायर कॉन्फ़िग आइटम को संशोधित करें',
    'secure_entry_route_conflicts' => 'सुरक्षा प्रवेश मार्ग संघर्ष',
    'language_exists' => 'भाषा पहले से मौजूद है',
    'language_not_exists' => 'भाषा मौजूद नहीं है',
    'plugin_not_exists' => 'प्लगइन मौजूद नहीं है',
    'map_exists' => 'मानचित्र सेवा प्रदाता का पहले ही उपयोग किया जा चुका है और इसे फिर से नहीं बनाया जा सकता है',
    'map_not_exists' => 'नक्शा मौजूद नहीं है',
    'required_user_role_name' => 'कृपया भूमिका का नाम भरें',
    'required_sticker_category_name' => 'कृपया इमोजी ग्रुप का नाम भरें',
    'required_group_category_name' => 'कृपया समूह श्रेणी का नाम भरें',
    'required_group_name' => 'कृपया समूह का नाम भरें',
    'delete_group_category_error' => 'श्रेणी के अंतर्गत एक समूह है, इसे हटाने की अनुमति नहीं है',
    'delete_default_language_error' => 'डिफ़ॉल्ट भाषा को हटाया नहीं जा सकता',
    'account_connect_services_error' => 'तृतीय-पक्ष इंटरकनेक्ट समर्थन में डुप्लिकेट इंटरकनेक्ट प्लेटफ़ॉर्म',
    'post_datetime_select_error' => 'पोस्ट द्वारा निर्धारित दिनांक सीमा खाली नहीं हो सकती',
    'post_datetime_select_range_error' => 'पद के लिए निर्धारित अंतिम तिथि प्रारंभ तिथि से कम नहीं हो सकती',
    'comment_datetime_select_error' => 'टिप्पणी के लिए निर्धारित दिनांक सीमा खाली नहीं हो सकती',
    'comment_datetime_select_range_error' => 'टिप्पणी सेटिंग की समाप्ति तिथि प्रारंभ तिथि से कम नहीं हो सकती है',
];
