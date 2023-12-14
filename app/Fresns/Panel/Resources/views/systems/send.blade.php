@extends('FsView::commons.sidebarLayout')

@section('sidebar')
    @include('FsView::systems.sidebar')
@endsection

@section('content')
    <!--header-->
    <div class="row mb-4">
        <div class="col-lg-7">
            <h3>{{ __('FsLang::panel.sidebar_send') }}</h3>
            <p class="text-secondary">{{ __('FsLang::panel.sidebar_send_intro') }}</p>
        </div>
        <div class="col-lg-5">
            <div class="input-group mt-2 mb-4 justify-content-lg-end">
                {{-- <a class="btn btn-outline-secondary" href="#" role="button">{{ __('FsLang::panel.button_support') }}</a> --}}
            </div>
        </div>
        <!--tab-list-->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="services-tab" data-bs-toggle="tab" data-bs-target="#services" type="button" role="tab" aria-controls="services" aria-selected="true">{{ __('FsLang::panel.sidebar_send_tab_services') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="templates-tab" data-bs-toggle="tab" data-bs-target="#templates" type="button" role="tab" aria-controls="templates" aria-selected="false">{{ __('FsLang::panel.sidebar_send_tab_templates') }}</button>
            </li>
        </ul>
    </div>

    <!--config-->
    <div class="tab-content" id="sendTabContent">
        <!--services-->
        <div class="tab-pane fade show active" id="services" role="tabpanel" aria-labelledby="services-tab">
            <form action="{{ route('panel.send.update') }}" method="post">
                @csrf
                @method('put')

                <!--email_config-->
                <div class="row mb-4">
                    <label class="col-lg-2 col-form-label text-lg-end">{{ __('FsLang::panel.send_email_config') }}:</label>
                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <label class="input-group-text">{{ __('FsLang::panel.table_service') }}</label>
                            <select class="form-select" name="send_email_service">
                                <option value="" {{ !$params['send_email_service'] ? 'selected' : '' }}>🚫 {{ __('FsLang::panel.option_deactivate') }}</option>
                                @foreach ($emailPlugins as $plugin)
                                    <option value="{{ $plugin->fskey }}" {{ $params['send_email_service'] == $plugin->fskey ? 'selected' : '' }}> {{ $plugin->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!--sms_config-->
                <div class="row mb-4">
                    <label class="col-lg-2 col-form-label text-lg-end">{{ __('FsLang::panel.send_sms_config') }}:</label>
                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <label class="input-group-text">{{ __('FsLang::panel.table_service') }}</label>
                            <select class="form-select" name="send_sms_service">
                                <option value="" {{ !$params['send_sms_service'] ? 'selected' : '' }}>🚫 {{ __('FsLang::panel.option_deactivate') }}</option>
                                @foreach ($smsPlugins as $plugin)
                                    <option value="{{ $plugin->fskey }}" {{ $params['send_sms_service'] == $plugin->fskey ? 'selected' : '' }}>{{ $plugin->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <label class="input-group-text">{{ __('FsLang::panel.send_sms_default_code') }}</label>
                            <span class="input-group-text">+</span>
                            <input type="number" class="form-control input-number" name="send_sms_default_code" placeholder="65" value="{{ $params['send_sms_default_code'] }}">
                        </div>
                        <div class="input-group mb-3">
                            <label class="input-group-text">{{ __('FsLang::panel.send_sms_supported_codes') }}</label>
                            <textarea class="form-control" name="send_sms_supported_codes" style="height: 200px">{!! $params['send_sms_supported_codes'] !!}</textarea>
                            <span class="input-group-text w-50 text-start text-wrap fs-7">{{ __('FsLang::panel.send_sms_desc') }}</span>
                        </div>
                    </div>
                </div>

                <!--ios_config-->
                <div class="row mb-4">
                    <label class="col-lg-2 col-form-label text-lg-end">{{ __('FsLang::panel.send_app_ios_config') }}:</label>
                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <label class="input-group-text">{{ __('FsLang::panel.send_app_notifications') }}</label>
                            <select class="form-select" name="ios_notifications_service">
                                <option value="" {{ !$params['ios_notifications_service'] ? 'selected' : '' }}>🚫 {{ __('FsLang::panel.option_deactivate') }}</option>
                                @foreach ($appPlugins as $plugin)
                                    <option value="{{ $plugin->fskey }}" {{ $params['ios_notifications_service'] == $plugin->fskey ? 'selected' : '' }}>{{ $plugin->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 form-text pt-1"><i class="bi bi-info-circle"></i> {{ __('FsLang::panel.send_app_ios_notifications_desc') }}</div>
                </div>

                <!--android_config-->
                <div class="row mb-4">
                    <label class="col-lg-2 col-form-label text-lg-end">{{ __('FsLang::panel.send_app_android_config') }}:</label>
                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <label class="input-group-text">{{ __('FsLang::panel.send_app_notifications') }}</label>
                            <select class="form-select" name="android_notifications_service">
                                <option value="" {{ !$params['android_notifications_service'] ? 'selected' : '' }}>🚫 {{ __('FsLang::panel.option_deactivate') }}</option>
                                @foreach ($appPlugins as $plugin)
                                    <option value="{{ $plugin->fskey }}" {{ $params['android_notifications_service'] == $plugin->fskey ? 'selected' : '' }}>{{ $plugin->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 form-text pt-1"><i class="bi bi-info-circle"></i> {{ __('FsLang::panel.send_app_android_notifications_desc') }}</div>
                </div>

                <!--desktop_config-->
                <div class="row mb-4">
                    <label class="col-lg-2 col-form-label text-lg-end">{{ __('FsLang::panel.send_app_desktop_config') }}:</label>
                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <label class="input-group-text">{{ __('FsLang::panel.send_app_notifications') }}</label>
                            <select class="form-select" name="desktop_notifications_service">
                                <option value="" {{ !$params['desktop_notifications_service'] ? 'selected' : '' }}>🚫 {{ __('FsLang::panel.option_deactivate') }}</option>
                                @foreach ($appPlugins as $plugin)
                                    <option value="{{ $plugin->fskey }}" {{ $params['desktop_notifications_service'] == $plugin->fskey ? 'selected' : '' }}>{{ $plugin->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 form-text pt-1"><i class="bi bi-info-circle"></i> {{ __('FsLang::panel.send_app_desktop_notifications_desc') }}</div>
                </div>

                <!--wechat_config-->
                <div class="row mb-4">
                    <label class="col-lg-2 col-form-label text-lg-end">{{ __('FsLang::panel.send_app_wechat_config') }}:</label>
                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <label class="input-group-text">{{ __('FsLang::panel.send_app_notifications') }}</label>
                            <select class="form-select" name="wechat_notifications_service">
                                <option value="" {{ !$params['wechat_notifications_service'] ? 'selected' : '' }}>🚫 {{ __('FsLang::panel.option_deactivate') }}</option>
                                @foreach ($wechatPlugins as $plugin)
                                    <option value="{{ $plugin->fskey }}" {{ $params['wechat_notifications_service'] == $plugin->fskey ? 'selected' : '' }}>{{ $plugin->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 form-text pt-1"><i class="bi bi-info-circle"></i> {{ __('FsLang::panel.send_app_wechat_notifications_desc') }}</div>
                </div>

                <!--button_save-->
                <div class="row my-3">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <button type="submit" class="btn btn-primary">{{ __('FsLang::panel.button_save') }}</button>
                    </div>
                </div>
            </form>
        </div>

        <!--templates-->
        <div class="tab-pane fade" id="templates" role="tabpanel" aria-labelledby="templates-tab">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap">
                    <thead>
                        <tr class="table-info">
                            <th scope="col" class="w-25">{{ __('FsLang::panel.table_number') }}</th>
                            <th scope="col">{{ __('FsLang::panel.table_use') }}</th>
                            <th scope="col">{{ __('FsLang::panel.table_support') }}</th>
                            <th scope="col" style="width:8rem;">{{ __('FsLang::panel.table_options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 0; ?>
                        @foreach ($templateConfigKeys as $name => $key)
                            <?php $index++; ?>
                            <tr>
                                <td>{{ $index }}</td>
                                <td>{{ $name }}</td>
                                <td>
                                    @if ($codeParams[$key]['email']['isEnabled'] ?? false)
                                        <span class="badge bg-success me-2">{{ __('FsLang::panel.option_email') }}</span>
                                    @endif
                                    @if ($codeParams[$key]['sms']['isEnabled'] ?? false)
                                        <span class="badge bg-success">{{ __('FsLang::panel.option_sms') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-primary btn-sm me-3"
                                        data-languages="{{ json_encode($codeParams[$key]['email']['templates'] ?? []) }}"
                                        data-enable="{{ $codeParams[$key]['email']['isEnabled'] ?? false }}"
                                        data-action="{{ route('panel.send.email.update', ['itemKey' => $key])}}"
                                        data-title="{{ $name }}"
                                        data-bs-toggle="modal" data-bs-target="#emailModal">
                                        {{ __('FsLang::panel.button_config_email_template') }}
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                        data-languages="{{ json_encode($codeParams[$key]['sms']['templates'] ?? []) }}"
                                        data-enable="{{ $codeParams[$key]['sms']['isEnabled'] ?? false }}"
                                        data-action="{{ route('panel.send.sms.update', ['itemKey' => $key])}}"
                                        data-title="{{ $name }}"
                                        data-bs-toggle="modal" data-bs-target="#smsModal">
                                        {{ __('FsLang::panel.button_config_sms_template') }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Email Modal -->
    <div class="modal fade" id="emailModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="emailModal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--form-->
                    <form method="post" action="">
                        @method('put')
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text">{{ __('FsLang::panel.table_status') }}</span>
                            <div class="form-control">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_enabled" id="email_status_true" value="1">
                                    <label class="form-check-label" for="email_status_true">{{ __('FsLang::panel.option_activate') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_enabled" id="email_status_false" value="0" checked>
                                    <label class="form-check-label" for="email_status_false">{{ __('FsLang::panel.option_deactivate') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-nowrap">
                                <thead>
                                    <tr class="table-info">
                                        <th scope="col">{{ __('FsLang::panel.table_lang_tag') }}</th>
                                        <th scope="col">{{ __('FsLang::panel.table_lang_name') }}</th>
                                        <th scope="col" class="w-50">{{ __('FsLang::panel.table_title') }} <i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('FsLang::panel.send_code_template_table_email_desc') }}"></i></th>
                                        <th scope="col" class="w-50">{{ __('FsLang::panel.table_content') }} <i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('FsLang::panel.send_code_template_table_email_desc') }}"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($optionalLanguages as $lang)
                                        <tr>
                                            <td>{{ $lang['langTag'] }}
                                                @if($lang['langTag'] == $defaultLanguage)
                                                    <i class="bi bi-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('FsLang::panel.default_language') }}" data-bs-original-title="{{ __('FsLang::panel.default_language') }}" aria-label="{{ __('FsLang::panel.default_language') }}"></i>
                                                @endif
                                            </td>
                                            <td>
                                                {{$lang['langName']}}
                                                @if ($lang['areaName'])
                                                    {{ '('.$lang['areaName'].')' }}
                                                @endif
                                            </td>
                                            <td><input type="text" name="titles[{{ $lang['langTag'] }}]" class="form-control title" value="{{ $langParams['name'][$lang['langTag']] ?? '' }}"></td>
                                            <td><textarea class="form-control content" name="contents[{{ $lang['langTag']}}]" rows="3"></textarea></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--button_save-->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{ __('FsLang::panel.button_save') }}</button>
                        </div>
                    </form>
                    <!--form end-->
                </div>
            </div>
        </div>
    </div>

    <!-- SMS Modal -->
    <div class="modal fade" id="smsModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="smsModal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--form-->
                    <form method="post" action="">
                        @method('put')
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text">{{ __('FsLang::panel.table_status') }}</span>
                            <div class="form-control">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_enabled" id="sms_status_true" value="1">
                                    <label class="form-check-label" for="sms_status_true">{{ __('FsLang::panel.option_activate') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_enabled" id="sms_status_false" value="0" checked>
                                    <label class="form-check-label" for="sms_status_false">{{ __('FsLang::panel.option_deactivate') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-nowrap">
                                <thead>
                                    <tr class="table-info">
                                        <th scope="col">{{ __('FsLang::panel.table_lang_tag') }}</th>
                                        <th scope="col">{{ __('FsLang::panel.table_lang_name') }}</th>
                                        <th scope="col" class="w-25">{{ __('FsLang::panel.send_code_template_table_sms_sign') }}</th>
                                        <th scope="col" class="w-25">{{ __('FsLang::panel.send_code_template_table_sms_code') }} <i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('FsLang::panel.send_code_template_table_sms_code_desc') }}"></i></th>
                                        <th scope="col" class="w-25">{{ __('FsLang::panel.send_code_template_table_sms_param') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($optionalLanguages as $lang)
                                        <tr>
                                            <td>{{ $lang['langTag'] }}
                                                @if($lang['langTag'] == $defaultLanguage)
                                                    <i class="bi bi-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('FsLang::panel.default_language') }}" data-bs-original-title="{{ __('FsLang::panel.default_language') }}" aria-label="{{ __('FsLang::panel.default_language') }}"></i>
                                                @endif
                                            </td>
                                            <td>
                                                {{$lang['langName']}}
                                                @if ($lang['areaName'])
                                                    {{ '('.$lang['areaName'].')' }}
                                                @endif
                                            </td>
                                            <td><input class="form-control" type="text" name="sign_names[{{ $lang['langTag']}}]"></td>
                                            <td><input class="form-control" type="text" name="template_codes[{{ $lang['langTag']}}]"></td>
                                            <td><input class="form-control" type="text" name="code_params[{{ $lang['langTag']}}]"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--button_save-->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{ __('FsLang::panel.button_save') }}</button>
                        </div>
                    </form>
                    <!--form end-->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            var activeTab = window.location.hash.substring(1);
            if (!activeTab) {
                activeTab = 'services-tab';
            }
            $('#' + activeTab).tab('show');
            document.documentElement.scrollIntoView({ behavior: 'smooth', block: 'start' });

            $('#myTab button').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
                document.documentElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    </script>
@endpush
