@extends('FsView::commons.sidebarLayout')

@section('sidebar')
    @include('FsView::clients.sidebar')
@endsection

@section('content')
    <!--menus header-->
    <div class="row mb-4 border-bottom">
        <div class="col-lg-7">
            <h3>{{ __('FsLang::panel.sidebar_menus') }}</h3>
            <p class="text-secondary">{{ __('FsLang::panel.sidebar_menus_intro') }}</p>
        </div>
        <div class="col-lg-5">
            <div class="input-group mt-2 mb-4 justify-content-lg-end">
                {{-- <a class="btn btn-outline-secondary" href="#" role="button">{{ __('FsLang::panel.button_support') }}</a> --}}
            </div>
        </div>
    </div>
    <!--menus config-->
    <div class="table-responsive">
        <table class="table table-hover align-middle text-nowrap">
            <thead>
                <tr class="table-info">
                    <th scope="col">{{ __('FsLang::panel.menu_table_home') }}</th>
                    <th scope="col">{{ __('FsLang::panel.menu_table_menu') }}</th>
                    <th scope="col">{{ __('FsLang::panel.menu_table_path') }}</th>
                    <th scope="col">{{ __('FsLang::panel.menu_table_name') }}</th>
                    <th scope="col">{{ __('FsLang::panel.menu_table_seo_title') }}</th>
                    <th scope="col">{{ __('FsLang::panel.menu_table_seo_description') }}</th>
                    <th scope="col">{{ __('FsLang::panel.menu_table_seo_keywords') }}</th>
                    <th scope="col">{{ __('FsLang::panel.table_status') }}</th>
                    <th scope="col">{{ __('FsLang::panel.table_options') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $key => $menu)
                    <tr>
                        <td>
                            @if ($menu['select'])
                                <input class="form-check-input update-config" type="radio" name="default_homepage" data-action="{{ route('panel.configs.update', ['config' => 'default_homepage']) }}" data-item_value="{{ $menu['controller'] }}" value="portal" {{ optional($configs['default_homepage'])->item_value == $menu['controller'] ? 'checked' : '' }}>
                            @endif
                        </td>
                        <td>{{ $menu['name'] }}</td>
                        <td>/{{ $menu['path'] ?? '' }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                data-placement="top" data-bs-toggle="modal" data-bs-target="#menuLangModal"
                                data-action="{{ route('panel.languages.batch.update', ['itemKey' => 'menu_' . $key . '_name']) }}"
                                data-languages="{{ optional($configs['menu_' . $key . '_name'])->languages->toJson() }}">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ optional($configs['menu_' . $key . '_name'])->item_value }}">{{ __('FsLang::panel.button_edit') }}</span>
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                data-placement="top" data-bs-toggle="modal" data-bs-target="#menuLangModal"
                                data-action="{{ route('panel.languages.batch.update', ['itemKey' => 'menu_' . $key . '_title']) }}"
                                data-languages="{{ optional($configs['menu_' . $key . '_title'])->languages->toJson() }}">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ optional($configs['menu_' . $key . '_title'])->item_value }}">{{ __('FsLang::panel.button_edit') }}</span>
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                data-placement="top" data-bs-toggle="modal" data-bs-target="#menuLangTextareaModal"
                                data-action="{{ route('panel.languages.batch.update', ['itemKey' => 'menu_' . $key . '_description']) }}"
                                data-languages="{{ optional($configs['menu_' . $key . '_description'])->languages->toJson() }}">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ optional($configs['menu_' . $key . '_description'])->item_value }}">{{ __('FsLang::panel.button_edit') }}</span>
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                data-placement="top" data-bs-toggle="modal" data-bs-target="#menuLangTextareaModal"
                                data-action="{{ route('panel.languages.batch.update', ['itemKey' => 'menu_' . $key . '_keywords']) }}"
                                data-languages="{{ optional($configs['menu_' . $key . '_keywords'])->languages->toJson() }}">
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ optional($configs['menu_' . $key . '_keywords'])->item_value }}">{{ __('FsLang::panel.button_edit') }}</span>
                            </button>
                        </td>
                        <td>
                            @if (optional($configs['menu_' . $key . '_status'])->item_value == 'true')
                                <i class="bi bi-check-lg text-success"></i>
                            @else
                                <i class="bi bi-dash-lg text-secondary"></i>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#menuEdit"
                                data-action="{{ route('panel.menus.update', ['key' => $key]) }}"
                                data-is_enabled="{{ optional($configs['menu_' . $key . '_status'])->item_value ?: 0 }}"
                                data-no_type="{{ $key == 'group' ? 0 : 1 }}"
                                data-type="{{ optional($configs['menu_' . $key . '_type'] ?? [])->item_value }}"
                                data-no_query_state="{{ $key == 'portal' ? 1 : 0 }}"
                                data-query_state="{{ optional($configs['menu_' . $key . '_query_state'] ?? [])->item_value }}"
                                data-no_query_config="{{ $key == 'portal' ? 1 : 0 }}"
                                data-query_config="{{ optional($configs['menu_' . $key . '_query_config'] ?? [])->item_value }}"
                                data-bs-whatever="{{ $menu['name'] }}">
                                {{ __('FsLang::panel.button_edit') }}
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!--menus config list end-->

    <!-- Modal Setting -->
    <div class="modal fade" id="menuEdit" tabindex="-1" aria-labelledby="menuEdit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('FsLang::panel.button_setting') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        @csrf
                        @method('put')
                        <!--status-->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">{{ __('FsLang::panel.table_status') }}</label>
                            <div class="col-sm-9 pt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_enabled" id="status_true" value="1" checked>
                                    <label class="form-check-label" for="status_true">{{ __('FsLang::panel.option_activate') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_enabled" id="status_false" value="0">
                                    <label class="form-check-label" for="status_false">{{ __('FsLang::panel.option_deactivate') }}</label>
                                </div>
                            </div>
                        </div>

                        <!--type-->
                        <div class="mb-3 row index-type">
                            <label class="col-sm-3 col-form-label">{{ __('FsLang::panel.table_type') }}</label>
                            <div class="col-sm-9 pt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="index_type" id="type_tree" value="tree" checked>
                                    <label class="form-check-label" for="type_tree">{{ __('FsLang::panel.option_type_tree') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="index_type" id="type_list" value="list">
                                    <label class="form-check-label" for="type_list">{{ __('FsLang::panel.option_type_list') }}</label>
                                </div>
                            </div>
                        </div>

                        <!--query state-->
                        <div class="mb-3 row query-state">
                            <label class="col-sm-3 col-form-label">{{ __('FsLang::panel.menu_table_query_state') }}</label>
                            <div class="col-sm-9 pt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="query_state" id="query_state_1" value="1" checked>
                                    <label class="form-check-label" for="query_state_1">{{ __('FsLang::panel.menu_query_state_1') }}</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="query_state" id="query_state_2" value="2">
                                    <label class="form-check-label" for="query_state_2">{{ __('FsLang::panel.menu_query_state_2') }}</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="query_state" id="query_state_3" value="3">
                                    <label class="form-check-label" for="query_state_3">{{ __('FsLang::panel.menu_query_state_3') }}</label>
                                </div>
                                <div class="form-text">{{ __('FsLang::panel.menu_table_query_state_desc') }}</div>
                            </div>
                        </div>

                        <!--query config-->
                        <div class="mb-3 row query-config">
                            <label class="col-sm-3 col-form-label">{{ __('FsLang::panel.menu_table_query_config') }}</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="query_config" rows="6"></textarea>
                                <div class="form-text">{{ __('FsLang::panel.menu_table_query_config_desc') }}</div>
                            </div>
                        </div>

                        <!--button_save-->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9"><button type="submit" class="btn btn-primary">{{ __('FsLang::panel.button_save') }}</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Language Modal (input) -->
    <div class="modal fade" id="menuLangModal" tabindex="-1" aria-labelledby="menuLangModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('FsLang::panel.button_setting') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        @csrf
                        @method('put')
                        <input type="hidden" name="sync_config" value="1">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-nowrap">
                                <thead>
                                    <tr class="table-info">
                                        <th scope="col" class="w-25">{{ __('FsLang::panel.table_lang_tag') }}</th>
                                        <th scope="col" class="w-25">{{ __('FsLang::panel.table_lang_name') }}</th>
                                        <th scope="col" class="w-50">{{ __('FsLang::panel.table_content') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($optionalLanguages as $lang)
                                        <tr>
                                            <td>
                                                {{ $lang['langTag'] }}
                                                @if ($lang['langTag'] == $defaultLanguage)
                                                    <i class="bi bi-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('FsLang::panel.default_language') }}"></i>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $lang['langName'] }}
                                                @if ($lang['areaName'])
                                                    {{ '('.$lang['areaName'].')' }}
                                                @endif
                                            </td>
                                            <td><input class="form-control" name="languages[{{ $lang['langTag'] }}]"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success" data-bs-dismiss="modal" aria-label="Close">{{ __('FsLang::panel.button_save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Language Modal (textarea) -->
    <div class="modal fade" id="menuLangTextareaModal" tabindex="-1" aria-labelledby="menuLangTextareaModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('FsLang::panel.button_setting') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        @csrf
                        @method('put')
                        <input type="hidden" name="sync_config" value="1">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-nowrap">
                                <thead>
                                    <tr class="table-info">
                                        <th scope="col" class="w-25">{{ __('FsLang::panel.table_lang_tag') }}</th>
                                        <th scope="col" class="w-25">{{ __('FsLang::panel.table_lang_name') }}</th>
                                        <th scope="col" class="w-50">{{ __('FsLang::panel.table_content') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($optionalLanguages as $lang)
                                        <tr>
                                            <td>
                                                {{ $lang['langTag'] }}
                                                @if ($lang['langTag'] == $defaultLanguage)
                                                    <i class="bi bi-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('FsLang::panel.default_language') }}"></i>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $lang['langName'] }}
                                                @if ($lang['areaName'])
                                                    {{ '('.$lang['areaName'].')' }}
                                                @endif
                                            </td>
                                            <td><textarea class="form-control" name="languages[{{ $lang['langTag'] }}]" rows="3"></textarea></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success" data-bs-dismiss="modal" aria-label="Close">{{ __('FsLang::panel.button_save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
