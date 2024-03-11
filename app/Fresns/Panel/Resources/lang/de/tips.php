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

    'createSuccess' => 'Erfolg erstellen',
    'deleteSuccess' => 'Löschen Erfolg',
    'updateSuccess' => 'Erfolgreich aktualisieren',
    'upgradeSuccess' => 'Upgrade erfolgreich',
    'installSuccess' => 'Erfolgreich installieren',
    'uninstallSuccess' => 'Erfolgreiche Deinstallation',

    'createFailure' => 'Fehlschlag erstellen',
    'deleteFailure' => 'Fehler löschen',
    'updateFailure' => 'Update-Fehler',
    'upgradeFailure' => 'Upgrade fehlgeschlagen',
    'installFailure' => 'Installation fehlgeschlagen',
    'downloadFailure' => 'Download Scheitern',
    'uninstallFailure' => 'Deinstallation fehlgeschlagen',

    'copySuccess' => 'Erfolg kopieren',
    'viewLog' => 'Bei der Implementierung ist ein Problem aufgetreten; Einzelheiten finden Sie im Fresns-Systemprotokoll',
    // auth empty
    'auth_empty_title' => 'Bitte verwenden Sie das richtige Portal, um sich am Panel anzumelden',
    'auth_empty_description' => 'Sie haben sich abgemeldet oder Ihr Login hat sich verzögert. Bitte besuchen Sie das Login-Portal, um sich erneut anzumelden.',
    // request
    'request_in_progress' => 'Anfrage in Bearbeitung...',
    'requestSuccess' => 'Erfolg anfordern',
    'requestFailure' => 'Anfrage Fehlschlag',
    // install
    'install_not_entered_key' => 'Bitte geben Sie den Fresns-Schlüssel ein',
    'install_not_entered_directory' => 'Bitte geben Sie ein Verzeichnis ein',
    'install_not_upload_zip' => 'Bitte wählen Sie das Installationspaket aus',
    'install_in_progress' => 'Installation im Gange...',
    'install_end' => 'Ende der Installation',
    // upgrade
    'upgrade_none' => 'Kein Update',
    'upgrade_fresns' => 'Für das Upgrade steht eine neue FRESNS-Version zur Verfügung',
    'upgrade_fresns_tip' => 'Sie können ein Upgrade auf ein Upgrade verwenden',
    'upgrade_fresns_warning' => 'Bitte erstellen Sie vor dem Upgrade eine Sicherungskopie Ihrer Datenbank, um Datenverluste aufgrund eines unsachgemäßen Upgrades zu vermeiden.',
    'upgrade_confirm_tip' => 'Upgrade bestimmen?',
    'manual_upgrade_tip' => 'Dieses Update unterstützt kein automatisches Upgrade, bitte verwenden Sie die Methode des "physischen Upgrades".',
    'manual_upgrade_version_guide' => 'Klicken Sie hier, um die Anweisungen für dieses Update zu lesen',
    'manual_upgrade_guide' => 'Upgrade-Leitfaden',
    'manual_upgrade_file_error' => 'Unstimmigkeit der physischen Upgrade-Datei',
    'manual_upgrade_confirm_tip' => 'Bitte vergewissern Sie sich, dass Sie die "Upgrade-Leitfaden" gelesen und die neue Version der Datei entsprechend der Anleitung verarbeitet haben.',
    'upgrade_in_progress' => 'Upgrade im Gange...',
    'auto_upgrade_step_1' => 'Initialisierungsüberprüfung',
    'auto_upgrade_step_2' => 'Anwendungspaket herunterladen',
    'auto_upgrade_step_3' => 'UNZIP-Anwendungspaket',
    'auto_upgrade_step_4' => 'Anwendung ein Upgrade',
    'auto_upgrade_step_5' => 'Den Cache leeren',
    'auto_upgrade_step_6' => 'Ziel',
    'manualUpgrade_step_1' => 'Initialisierungsüberprüfung',
    'manualUpgrade_step_2' => 'Daten aktualisieren',
    'manualUpgrade_step_3' => 'Alle Plugin-Abhängigkeitspakete installieren (dieser Schritt ist ein langsamer Prozess, bitte haben Sie Geduld)',
    'manualUpgrade_step_4' => 'Veröffentlichen und Wiederherstellen der aktivierten Erweiterungen',
    'manualUpgrade_step_5' => 'Fresns Versionsinformationen aktualisieren',
    'manualUpgrade_step_6' => 'Den Cache leeren',
    'manualUpgrade_step_7' => 'Ziel',
    // uninstall
    'uninstall_in_progress' => 'Deinstallation im Gange...',
    'uninstall_step_1' => 'Initialisierungsüberprüfung',
    'uninstall_step_2' => 'Datenverarbeitung',
    'uninstall_step_3' => 'Dateien löschen',
    'uninstall_step_4' => 'Cache leeren',
    'uninstall_step_5' => 'Getan',
    // select
    'select_box_tip_plugin' => 'Plugin auswählen',
    'select_box_tip_role' => 'Wählen Sie eine Rolle aus',
    'select_box_tip_group' => 'Wählen Sie eine Gruppe aus',
    'post_datetime_select_error' => 'Der Datumsbereich der Posteinstellungen kann nicht leer sein',
    'post_datetime_select_range_error' => 'Das Enddatum der Posteinstellung kann nicht weniger als das Startdatum sein',
    'comment_datetime_select_error' => 'Der vom Kommentar festgelegte Datumsbereich kann nicht leer sein',
    'comment_datetime_select_range_error' => 'Das Enddatum der Kommentareinstellung kann nicht weniger als das Startdatum sein',
    // delete app
    'delete_app_warning' => 'Wenn Sie keine Update-Warnung für die App anzeigen möchten, können Sie die App löschen. Nach dem Löschen werden Sie nicht mehr benachrichtigt, wenn eine neue Version verfügbar ist.',
    // dashboard
    'panel_config' => 'Nach der Änderung der Konfiguration muss der Cache geleert werden, bevor die neue Konfiguration wirksam werden kann.',
    'plugin_install_or_upgrade' => 'Nachdem das Plugin installiert oder aktualisiert wurde, ist es standardmäßig deaktiviert und muss manuell aktiviert werden, um Systemprobleme zu vermeiden, die durch Fehler im Plugin verursacht werden.',
    // website
    'website_path_empty_error' => 'Speichern fehlgeschlagen, Pfadparameter darf nicht leer sein',
    'website_path_format_error' => 'konnte nicht gespeichert werden, Pfadparameter werden nur in Klartext unterstützt',
    'website_path_reserved_error' => 'Speichern fehlgeschlagen, Pfadparameter enthält vom System reservierten Parameternamen',
    'website_path_unique_error' => 'Speichern fehlgeschlagen, doppelte Pfadparameter, die Namen der Pfadparameter dürfen sich nicht wiederholen',
    // theme
    'website_engine_error' => 'Website-Engine nicht installiert',
    'theme_error' => 'Das Thema ist falsch oder existiert nicht',
    'theme_functions_file_error' => 'Die Ansichtsdatei der Themenkonfiguration ist falsch oder existiert nicht',
    'theme_json_file_error' => 'Die Konfigurationsdatei des Themas ist falsch oder nicht vorhanden',
    'theme_json_format_error' => 'Die Theme-Konfigurationsdatei hat das falsche Format',
    // others
    'markdown_editor' => 'Der Inhalt unterstützt die Markdown-Syntax, aber das Eingabefeld unterstützt keine Vorschau. Bitte speichern Sie es auf dem Client, um den Effekt zu sehen.',
    'account_not_found' => 'Konto ist nicht vorhanden oder geben Fehler ein',
    'account_login_limit' => 'Der Fehler hat das Systemlimit überschritten. Bitte melden Sie sich 1 Stunde später erneut an',
    'timezone_error' => 'Die Zeitzone der Datenbank stimmt nicht mit der Zeitzone in der Konfigurationsdatei .env überein',
    'timezone_env_edit_tip' => 'Bitte ändern Sie den Konfigurationseintrag timezone identifier in der .env-Datei',
    'secure_entry_route_conflicts' => 'Sicherheitseingang-Routing-Konflikt',
    'language_exists' => 'Sprache existiert bereits',
    'language_not_exists' => 'Sprache nicht vorhanden',
    'plugin_not_exists' => 'plugin nicht vorhanden',
    'map_exists' => 'Dieser Kartendienstanbieter wurde bereits verwendet und kann nicht neu erstellt werden',
    'map_not_exists' => 'Karte nicht vorhanden',
    'required_user_role_name' => 'Bitte füllen Sie den Namen der Rolle aus',
    'required_sticker_category_name' => 'Bitte füllen Sie den Namen der Expression-Gruppe aus',
    'required_group_name' => 'Bitte füllen Sie den Gruppennamen aus',
    'delete_default_language_error' => 'Die Standardsprache kann nicht gelöscht werden',
    'account_connect_services_error' => 'Die Unterstützung von Drittanbietern verfügt über eine sich wiederholende miteinander verbundene Plattform',
];
