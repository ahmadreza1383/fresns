@extends('FsView::commons.sidebarLayout')

@section('sidebar')
    @include('FsView::operations.sidebar')
@endsection

@section('content')
    <!--interaction header-->
    <div class="row mb-4 border-bottom">
        <div class="col-lg-7">
            <h3>{{ __('FsLang::panel.sidebar_interaction') }}</h3>
            <p class="text-secondary">{{ __('FsLang::panel.sidebar_interaction_intro') }}</p>
        </div>
        <div class="col-lg-5">
            <div class="input-group mt-2 mb-4 justify-content-lg-end">
                {{-- <a class="btn btn-outline-secondary" href="#" role="button">{{ __('FsLang::panel.button_support') }}</a> --}}
            </div>
        </div>
    </div>
    <!--interaction config-->
    <form action="{{ route('panel.interaction.update') }}" method="post">
        @csrf
        @method('put')
        <!--interaction_content_config-->
        <!-- mention -->
        <div class="row">
            <label class="col-lg-2 col-form-label text-lg-end">{{ __('FsLang::panel.interaction_content_config') }}:</label>
            <div class="col-lg-6">
                <div class="input-group">
                    <label class="input-group-text">{{ __('FsLang::panel.interaction_mention_status') }}</label>
                    <div class="form-control bg-white">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="mention_status" id="mention_status_true" value="true" {{ $params['mention_status'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="mention_status_true">{{ __('FsLang::panel.option_open') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="mention_status" id="mention_status_false" value="false" {{ ! $params['mention_status'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="mention_status_false">{{ __('FsLang::panel.option_close') }}</label>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>

        <!-- hashtag -->
        <div class="row mb-3">
            <label class="col-lg-2 col-form-label text-lg-end"></label>
            <div class="col-lg-6">
                <div class="input-group">
                    <label class="input-group-text">{{ __('FsLang::panel.interaction_hashtag_status') }}</label>
                    <div class="form-control bg-white">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hashtag_status" id="hashtag_status_true" value="true" {{ $params['hashtag_status'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="hashtag_status_true">{{ __('FsLang::panel.option_open') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hashtag_status" id="hashtag_status_false" value="false" {{ ! $params['hashtag_status'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="hashtag_status_false">{{ __('FsLang::panel.option_close') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-lg-2 col-form-label text-lg-end"></label>
            <div class="col-lg-6">
                <div class="input-group">
                    <label class="input-group-text">{{ __('FsLang::panel.interaction_hashtag_format') }}</label>
                    <div class="form-control bg-white">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hashtag_format" id="hashtag_format_1" value="1" {{ $params['hashtag_format'] == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="hashtag_format_1">{{ __('FsLang::panel.interaction_hashtag_format_1') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hashtag_format" id="hashtag_format_2" value="2" {{ $params['hashtag_format'] == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="hashtag_format_2">{{ __('FsLang::panel.interaction_hashtag_format_2') }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 form-text pt-1"><i class="bi bi-info-circle"></i> {!! __('FsLang::panel.interaction_hashtag_format_desc') !!}</div>
        </div>
        <div class="row mb-3">
            <label class="col-lg-2 col-form-label text-lg-end"></label>
            <div class="col-lg-6">
                <div class="input-group">
                    <label class="input-group-text">{{ __('FsLang::panel.interaction_hashtag_length') }}</label>
                    <input type="number" class="form-control input-number" name="hashtag_length" value="{{ $params['hashtag_length'] }}">
                    <span class="input-group-text">{{ __('FsLang::panel.unit_character') }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <label class="col-lg-2 col-form-label text-lg-end"></label>
            <div class="col-lg-6">
                <div class="input-group">
                    <label class="input-group-text">{{ __('FsLang::panel.interaction_hashtag_regexp') }}</label>
                    <button class="btn btn-outline-secondary" style="flex: 1 1 auto;" type="button" data-bs-toggle="modal" data-bs-target="#hashtagRegexpModal">{{ __('FsLang::panel.button_config') }}</button>
                </div>
                <hr>
            </div>
        </div>

        <!-- post -->
        <div class="row mb-3">
            <label class="col-lg-2 col-form-label text-lg-end"></label>
            <div class="col-lg-6">
                <div class="input-group">
                    <label class="input-group-text">{{ __('FsLang::panel.interaction_preview_post_like_users') }}</label>
                    <select class="form-select" name="preview_post_like_users">
                        <option value="0" {{ $params['preview_post_like_users'] == 0 ? 'selected' : '' }}>{{ __('FsLang::panel.option_close') }}</option>
                        <option value="1" {{ $params['preview_post_like_users'] == 1 ? 'selected' : '' }}>1</option>
                        <option value="2" {{ $params['preview_post_like_users'] == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ $params['preview_post_like_users'] == 3 ? 'selected' : '' }}>3</option>
                        <option value="4" {{ $params['preview_post_like_users'] == 4 ? 'selected' : '' }}>4</option>
                        <option value="5" {{ $params['preview_post_like_users'] == 5 ? 'selected' : '' }}>5</option>
                        <option value="6" {{ $params['preview_post_like_users'] == 6 ? 'selected' : '' }}>6</option>
                        <option value="7" {{ $params['preview_post_like_users'] == 7 ? 'selected' : '' }}>7</option>
                        <option value="8" {{ $params['preview_post_like_users'] == 8 ? 'selected' : '' }}>8</option>
                        <option value="9" {{ $params['preview_post_like_users'] == 9 ? 'selected' : '' }}>9</option>
                        <option value="10" {{ $params['preview_post_like_users'] == 10 ? 'selected' : '' }}>10</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 form-text pt-1"><i class="bi bi-info-circle"></i> {{ __('FsLang::panel.interaction_preview_post_like_users_desc') }}</div>
        </div>
        <div class="row mb-1">
            <label class="col-lg-2 col-form-label text-lg-end"></label>
            <div class="col-lg-6">
                <div class="input-group">
                    <label class="input-group-text">{{ __('FsLang::panel.interaction_preview_post_comments') }}</label>
                    <select class="form-select" name="preview_post_comments">
                        <option value="0" {{ $params['preview_post_comments'] == 0 ? 'selected' : '' }}>{{ __('FsLang::panel.option_close') }}</option>
                        <option value="1" {{ $params['preview_post_comments'] == 1 ? 'selected' : '' }}>1</option>
                        <option value="2" {{ $params['preview_post_comments'] == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ $params['preview_post_comments'] == 3 ? 'selected' : '' }}>3</option>
                        <option value="4" {{ $params['preview_post_comments'] == 4 ? 'selected' : '' }}>4</option>
                        <option value="5" {{ $params['preview_post_comments'] == 5 ? 'selected' : '' }}>5</option>
                    </select>
                    <select class="form-select" name="preview_post_comment_sort">
                        <option disabled>{{ __('FsLang::panel.table_order') }}</option>
                        <option value="like" {{ $params['preview_post_comment_sort'] == 'like' ? 'selected' : '' }}>Like Count</option>
                        <option value="comment" {{ $params['preview_post_comment_sort'] == 'comment' ? 'selected' : '' }}>Comment Count</option>
                        <option value="oldest" {{ $params['preview_post_comment_sort'] == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="latest" {{ $params['preview_post_comment_sort'] == 'latest' ? 'selected' : '' }}>Latest</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 form-text pt-1"><i class="bi bi-info-circle"></i> {{ __('FsLang::panel.interaction_preview_post_comments_desc') }}</div>
        </div>
        <div class="row">
            <label class="col-lg-2 col-form-label text-lg-end"></label>
            <div class="col-lg-6">
                <div class="input-group">
                    <label class="input-group-text">{{ __('FsLang::panel.interaction_preview_post_comment_require') }}</label>
                    <input type="number" class="form-control input-number" name="preview_post_comment_require" value="{{ $params['preview_post_comment_require'] }}">
                    <span class="input-group-text">Like Count / Comment Count</span>
                </div>
                <hr>
            </div>
            <div class="col-lg-4 form-text pt-1"><i class="bi bi-info-circle"></i> {{ __('FsLang::panel.interaction_preview_post_comment_require_desc') }}</div>
        </div>

        <!-- comment -->
        <div class="row mb-3">
            <label class="col-lg-2 col-form-label text-lg-end"></label>
            <div class="col-lg-6">
                <div class="input-group">
                    <label class="input-group-text">{{ __('FsLang::panel.interaction_comment_visibility_rule') }}</label>
                    <input type="number" class="form-control input-number" name="comment_visibility_rule" value="{{ $params['comment_visibility_rule'] }}">
                    <span class="input-group-text">{{ __('FsLang::panel.unit_day') }}</span>
                </div>
            </div>
            <div class="col-lg-4 form-text pt-1"><i class="bi bi-info-circle"></i> {{ __('FsLang::panel.interaction_comment_visibility_rule_desc') }}</div>
        </div>
        <div class="row">
            <label class="col-lg-2 col-form-label text-lg-end"></label>
            <div class="col-lg-6">
                <div class="input-group">
                    <label class="input-group-text">{{ __('FsLang::panel.interaction_preview_sub_comments') }}</label>
                    <select class="form-select" name="preview_sub_comments">
                        <option value="0" {{ $params['preview_sub_comments'] == 0 ? 'selected' : '' }}>{{ __('FsLang::panel.option_close') }}</option>
                        <option value="1" {{ $params['preview_sub_comments'] == 1 ? 'selected' : '' }}>1</option>
                        <option value="2" {{ $params['preview_sub_comments'] == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ $params['preview_sub_comments'] == 3 ? 'selected' : '' }}>3</option>
                        <option value="4" {{ $params['preview_sub_comments'] == 4 ? 'selected' : '' }}>4</option>
                        <option value="5" {{ $params['preview_sub_comments'] == 5 ? 'selected' : '' }}>5</option>
                    </select>
                    <select class="form-select" name="preview_sub_comment_sort">
                        <option disabled>{{ __('FsLang::panel.table_order') }}</option>
                        <option value="like" {{ $params['preview_sub_comment_sort'] == 'like' ? 'selected' : '' }}>Like Count</option>
                        <option value="oldest" {{ $params['preview_sub_comment_sort'] == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="latest" {{ $params['preview_sub_comment_sort'] == 'latest' ? 'selected' : '' }}>Latest</option>
                    </select>
                </div>
                <hr>
            </div>
            <div class="col-lg-4 form-text pt-1"><i class="bi bi-info-circle"></i> {{ __('FsLang::panel.interaction_preview_sub_comments_desc') }}</div>
        </div>

        <div class="row mb-1">
            <label class="col-lg-2 col-form-label text-lg-end"></label>
            <div class="col-lg-6">
                <div class="input-group">
                    <label class="input-group-text">{{ __('FsLang::panel.interaction_nearby_length') }}</label>
                    <input type="number" class="form-control input-number" name="nearby_length_km" value="{{ $params['nearby_length_km'] }}">
                    <span class="input-group-text">{{ __('FsLang::panel.unit_kilometer') }}</span>
                </div>
            </div>
            <div class="col-lg-4 form-text pt-1"><i class="bi bi-info-circle"></i> {{ __('FsLang::panel.interaction_nearby_length_desc') }}</div>
        </div>

        <div class="row mb-5">
            <label class="col-lg-2 col-form-label text-lg-end"></label>
            <div class="col-lg-6">
                <div class="input-group">
                    <label class="input-group-text">{{ __('FsLang::panel.interaction_nearby_length') }}</label>
                    <input type="number" class="form-control input-number" name="nearby_length_mi" value="{{ $params['nearby_length_mi'] }}">
                    <span class="input-group-text">{{ __('FsLang::panel.unit_mile') }}</span>
                </div>
            </div>
            <div class="col-lg-4 form-text pt-1"><i class="bi bi-info-circle"></i> {{ __('FsLang::panel.interaction_nearby_length_desc') }}</div>
        </div>

        <!--interaction_conversation_config-->
        <div class="row mb-3">
            <label class="col-lg-2 col-form-label text-lg-end">{{ __('FsLang::panel.interaction_conversation_config') }}:</label>
            <div class="col-lg-6">
                <div class="input-group">
                    <label class="input-group-text">{{ __('FsLang::panel.interaction_conversation_status') }}</label>
                    <div class="form-control bg-white">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="conversation_status" id="conversation_status_true" value="true" data-bs-toggle="collapse" data-bs-target=".conversation_setting:not(.show)" aria-expanded="false" aria-controls="conversation_setting" {{ $params['conversation_status'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="conversation_status_true">{{ __('FsLang::panel.option_open') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="conversation_status" id="conversation_status_false" value="false" data-bs-toggle="collapse" data-bs-target=".conversation_setting.show" aria-expanded="false" aria-controls="conversation_setting" {{ !$params['conversation_status'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="conversation_status_false">{{ __('FsLang::panel.option_close') }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 form-text pt-1"><i class="bi bi-info-circle"></i> {{ __('FsLang::panel.interaction_conversation_status_desc') }}</div>
        </div>

        <div class="collapse conversation_setting {{ $params['conversation_status'] ? 'show' : '' }}">
            <div class="row">
                <label class="col-lg-2 col-form-label text-lg-end"></label>
                <div class="col-lg-6">
                    <div class="input-group">
                        <label class="input-group-text">{{ __('FsLang::panel.interaction_conversation_files') }}</label>
                        <div class="form-control bg-white">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="conversation_file_image" name="conversation_files[]" value="image" {{ in_array('image', $params['conversation_files']) ? 'checked' : '' }}>
                                <label class="form-check-label" for="conversation_file_image">{{ __('FsLang::panel.editor_image') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="conversation_file_video" name="conversation_files[]" value="video" {{ in_array('video', $params['conversation_files']) ? 'checked' : '' }}>
                                <label class="form-check-label" for="conversation_file_video">{{ __('FsLang::panel.editor_video') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="conversation_file_audio" name="conversation_files[]" value="audio" {{ in_array('audio', $params['conversation_files']) ? 'checked' : '' }}>
                                <label class="form-check-label" for="conversation_file_audio">{{ __('FsLang::panel.editor_audio') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="conversation_file_document" name="conversation_files[]" value="document" {{ in_array('document', $params['conversation_files']) ? 'checked' : '' }}>
                                <label class="form-check-label" for="conversation_file_document">{{ __('FsLang::panel.editor_document') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 form-text pt-1"><i class="bi bi-info-circle"></i> {{ __('FsLang::panel.interaction_conversation_files_desc') }}</div>
            </div>
        </div>

        <!--interaction_follow_config-->
        <div class="row mt-5">
            <label class="col-lg-2 col-form-label text-lg-end">{{ __('FsLang::panel.interaction_follow_config') }}:</label>
            <div class="col-lg-6">
                <div class="input-group">
                    <div class="form-control bg-white">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="view_posts_by_follow_object" name="view_posts_by_follow_object" value="true" class="form-check-input" {{ $params['view_posts_by_follow_object'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="view_posts_by_follow_object">{{ __('FsLang::panel.interaction_view_posts_by_follow_object') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="view_comments_by_follow_object" name="view_comments_by_follow_object" value="true" class="form-check-input" {{ $params['view_comments_by_follow_object'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="view_comments_by_follow_object">{{ __('FsLang::panel.interaction_view_comments_by_follow_object') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--interaction_function_config-->
        <div class="row mt-5">
            <label class="col-lg-2 col-form-label text-lg-end">{{ __('FsLang::panel.interaction_function_config') }}:</label>
            <div class="col-lg-10">
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="like_user" name="like_user_setting" value="true" class="form-check-input" {{ $params['like_user_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="like_user">{{ __('FsLang::panel.interaction_like_user') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="like_group" name="like_group_setting" value="true" class="form-check-input" {{ $params['like_group_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="like_group">{{ __('FsLang::panel.interaction_like_group') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="like_hashtag" name="like_hashtag_setting" value="true" class="form-check-input" {{ $params['like_hashtag_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="like_hashtag">{{ __('FsLang::panel.interaction_like_hashtag') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="like_post" name="like_post_setting" value="true" class="form-check-input" {{ $params['like_post_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="like_post">{{ __('FsLang::panel.interaction_like_post') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="like_comment" name="like_comment_setting" value="true" class="form-check-input" {{ $params['like_comment_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="like_comment">{{ __('FsLang::panel.interaction_like_comment') }}</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="dislike_user" name="dislike_user_setting" value="true" class="form-check-input" {{ $params['dislike_user_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="dislike_user">{{ __('FsLang::panel.interaction_dislike_user') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="dislike_group" name="dislike_group_setting" value="true" class="form-check-input" {{ $params['dislike_group_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="dislike_group">{{ __('FsLang::panel.interaction_dislike_group') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="dislike_hashtag" name="dislike_hashtag_setting" value="true" class="form-check-input" {{ $params['dislike_hashtag_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="dislike_hashtag">{{ __('FsLang::panel.interaction_dislike_hashtag') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="dislike_post" name="dislike_post_setting" value="true" class="form-check-input" {{ $params['dislike_post_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="dislike_post">{{ __('FsLang::panel.interaction_dislike_post') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="dislike_comment" name="dislike_comment_setting" value="true" class="form-check-input" {{ $params['dislike_comment_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="dislike_comment">{{ __('FsLang::panel.interaction_dislike_comment') }}</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="follow_user" name="follow_user_setting" value="true" class="form-check-input" {{ $params['follow_user_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="follow_user">{{ __('FsLang::panel.interaction_follow_user') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="follow_group" name="follow_group_setting" value="true" class="form-check-input" {{ $params['follow_group_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="follow_group">{{ __('FsLang::panel.interaction_follow_group') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="follow_hashtag" name="follow_hashtag_setting" value="true" class="form-check-input" {{ $params['follow_hashtag_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="follow_hashtag">{{ __('FsLang::panel.interaction_follow_hashtag') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="follow_post" name="follow_post_setting" value="true" class="form-check-input" {{ $params['follow_post_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="follow_post">{{ __('FsLang::panel.interaction_follow_post') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="follow_comment" name="follow_comment_setting" value="true" class="form-check-input" {{ $params['follow_comment_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="follow_comment">{{ __('FsLang::panel.interaction_follow_comment') }}</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="block_user" name="block_user_setting" value="true" class="form-check-input" {{ $params['block_user_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="block_user">{{ __('FsLang::panel.interaction_block_user') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="block_group" name="block_group_setting" value="true" class="form-check-input" {{ $params['block_group_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="block_group">{{ __('FsLang::panel.interaction_block_group') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="block_hashtag" name="block_hashtag_setting" value="true" class="form-check-input" {{ $params['block_hashtag_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="block_hashtag">{{ __('FsLang::panel.interaction_block_hashtag') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="block_post" name="block_post_setting" value="true" class="form-check-input" {{ $params['block_post_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="block_post">{{ __('FsLang::panel.interaction_block_post') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="block_comment" name="block_comment_setting" value="true" class="form-check-input" {{ $params['block_comment_setting'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="block_comment">{{ __('FsLang::panel.interaction_block_comment') }}</label>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-2"></div>
            <div class="col-lg-10 form-text pt-1"><i class="bi bi-info-circle"></i> {{ __('FsLang::panel.interaction_function_config_desc') }}</div>
        </div>

        <!--interaction_view_config-->
        <div class="row mt-5">
            <label class="col-lg-2 col-form-label text-lg-end">{{ __('FsLang::panel.interaction_view_config') }}:</label>
            <!--interaction_view_content-->
            <div class="col-lg-10 mb-3">
                <ul class="list-group">
                    <li class="list-group-item list-group-item-secondary">{{ __('FsLang::panel.interaction_view_content') }}</li>
                    <li class="list-group-item">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_posts" name="it_posts" value="true" class="form-check-input" {{ $params['it_posts'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_posts">{{ __('FsLang::panel.interaction_it_posts') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_comments" name="it_comments" value="true" class="form-check-input" {{ $params['it_comments'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_comments">{{ __('FsLang::panel.interaction_it_comments') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_followers_you_follow" name="it_followers_you_follow" value="true" class="form-check-input" {{ $params['it_followers_you_follow'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_followers_you_follow">{{ __('FsLang::panel.interaction_it_followers_you_follow') }}</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_like_users" name="it_like_users" value="true" class="form-check-input" {{ $params['it_like_users'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_like_users">{{ __('FsLang::panel.interaction_it_like_users') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_like_groups" name="it_like_groups" value="true" class="form-check-input" {{ $params['it_like_groups'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_like_groups">{{ __('FsLang::panel.interaction_it_like_groups') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_like_hashtags" name="it_like_hashtags" value="true" class="form-check-input" {{ $params['it_like_hashtags'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_like_hashtags">{{ __('FsLang::panel.interaction_it_like_hashtags') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_like_posts" name="it_like_posts" value="true" class="form-check-input" {{ $params['it_like_posts'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_like_posts">{{ __('FsLang::panel.interaction_it_like_posts') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_like_comments" name="it_like_comments" value="true" class="form-check-input" {{ $params['it_like_comments'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_like_comments">{{ __('FsLang::panel.interaction_it_like_comments') }}</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_dislike_users" name="it_dislike_users" value="true" class="form-check-input" {{ $params['it_dislike_users'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_dislike_users">{{ __('FsLang::panel.interaction_it_dislike_users') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_dislike_groups" name="it_dislike_groups" value="true" class="form-check-input" {{ $params['it_dislike_groups'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_dislike_groups">{{ __('FsLang::panel.interaction_it_dislike_groups') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_dislike_hashtags" name="it_dislike_hashtags" value="true" class="form-check-input" {{ $params['it_dislike_hashtags'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_dislike_hashtags">{{ __('FsLang::panel.interaction_it_dislike_hashtags') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_dislike_posts" name="it_dislike_posts" value="true" class="form-check-input" {{ $params['it_dislike_posts'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_dislike_posts">{{ __('FsLang::panel.interaction_it_dislike_posts') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_dislike_comments" name="it_dislike_comments" value="true" class="form-check-input" {{ $params['it_dislike_comments'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_dislike_comments">{{ __('FsLang::panel.interaction_it_dislike_comments') }}</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_follow_users" name="it_follow_users" value="true" class="form-check-input" {{ $params['it_follow_users'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_follow_users">{{ __('FsLang::panel.interaction_it_follow_users') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_follow_groups" name="it_follow_groups" value="true" class="form-check-input" {{ $params['it_follow_groups'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_follow_groups">{{ __('FsLang::panel.interaction_it_follow_groups') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_follow_hashtags" name="it_follow_hashtags" value="true" class="form-check-input" {{ $params['it_follow_hashtags'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_follow_hashtags">{{ __('FsLang::panel.interaction_it_follow_hashtags') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_follow_posts" name="it_follow_posts" value="true" class="form-check-input" {{ $params['it_follow_posts'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_follow_posts">{{ __('FsLang::panel.interaction_it_follow_posts') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_follow_comments" name="it_follow_comments" value="true" class="form-check-input" {{ $params['it_follow_comments'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_follow_comments">{{ __('FsLang::panel.interaction_it_follow_comments') }}</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_block_users" name="it_block_users" value="true" class="form-check-input" {{ $params['it_block_users'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_block_users">{{ __('FsLang::panel.interaction_it_block_users') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_block_groups" name="it_block_groups" value="true" class="form-check-input" {{ $params['it_block_groups'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_block_groups">{{ __('FsLang::panel.interaction_it_block_groups') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_block_hashtags" name="it_block_hashtags" value="true" class="form-check-input" {{ $params['it_block_hashtags'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_block_hashtags">{{ __('FsLang::panel.interaction_it_block_hashtags') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_block_posts" name="it_block_posts" value="true" class="form-check-input" {{ $params['it_block_posts'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_block_posts">{{ __('FsLang::panel.interaction_it_block_posts') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="it_block_comments" name="it_block_comments" value="true" class="form-check-input" {{ $params['it_block_comments'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="it_block_comments">{{ __('FsLang::panel.interaction_it_block_comments') }}</label>
                        </div>
                    </li>
                </ul>
            </div>
            <label class="col-lg-2"></label>
            <!--interaction_user_profile-->
            <div class="col-lg-10 mb-3">
                <ul class="list-group">
                    <li class="list-group-item list-group-item-secondary">{{ __('FsLang::panel.interaction_user_profile') }}</li>
                    <li class="list-group-item">
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_posts" name="it_home_list" value="it_posts" class="form-check-input" {{ $params['it_home_list'] == 'it_posts' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_posts">{{ __('FsLang::panel.interaction_it_posts') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_comments" name="it_home_list" value="it_comments" class="form-check-input" {{ $params['it_home_list'] == 'it_comments' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_comments">{{ __('FsLang::panel.interaction_it_comments') }}</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-user_likers" name="it_home_list" value="user_likers" class="form-check-input" {{ $params['it_home_list'] == 'user_likers' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-user_likers">{{ __('FsLang::panel.interaction_like_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-user_dislikers" name="it_home_list" value="user_dislikers" class="form-check-input" {{ $params['it_home_list'] == 'user_dislikers' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-user_dislikers">{{ __('FsLang::panel.interaction_dislike_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-user_followers" name="it_home_list" value="user_followers" class="form-check-input" {{ $params['it_home_list'] == 'user_followers' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-user_followers">{{ __('FsLang::panel.interaction_follow_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-user_blockers" name="it_home_list" value="user_blockers" class="form-check-input" {{ $params['it_home_list'] == 'user_blockers' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-user_blockers">{{ __('FsLang::panel.interaction_block_it') }}</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_like_users" name="it_home_list" value="it_like_users" class="form-check-input" {{ $params['it_home_list'] == 'it_like_users' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_like_users">{{ __('FsLang::panel.interaction_it_like_users') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_like_groups" name="it_home_list" value="it_like_groups" class="form-check-input" {{ $params['it_home_list'] == 'it_like_groups' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_like_groups">{{ __('FsLang::panel.interaction_it_like_groups') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_like_hashtags" name="it_home_list" value="it_like_hashtags" class="form-check-input" {{ $params['it_home_list'] == 'it_like_hashtags' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_like_hashtags">{{ __('FsLang::panel.interaction_it_like_hashtags') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_like_posts" name="it_home_list" value="it_like_posts" class="form-check-input" {{ $params['it_home_list'] == 'it_like_posts' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_like_posts">{{ __('FsLang::panel.interaction_it_like_posts') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_like_comments" name="it_home_list" value="it_like_comments" class="form-check-input" {{ $params['it_home_list'] == 'it_like_comments' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_like_comments">{{ __('FsLang::panel.interaction_it_like_comments') }}</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_dislike_users" name="it_home_list" value="it_dislike_users" class="form-check-input" {{ $params['it_home_list'] == 'it_dislike_users' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_dislike_users">{{ __('FsLang::panel.interaction_it_dislike_users') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_dislike_groups" name="it_home_list" value="it_dislike_groups" class="form-check-input" {{ $params['it_home_list'] == 'it_dislike_groups' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_dislike_groups">{{ __('FsLang::panel.interaction_it_dislike_groups') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_dislike_hashtags" name="it_home_list" value="it_dislike_hashtags" class="form-check-input" {{ $params['it_home_list'] == 'it_dislike_hashtags' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_dislike_hashtags">{{ __('FsLang::panel.interaction_it_dislike_hashtags') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_dislike_posts" name="it_home_list" value="it_dislike_posts" class="form-check-input" {{ $params['it_home_list'] == 'it_dislike_posts' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_dislike_posts">{{ __('FsLang::panel.interaction_it_dislike_posts') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_dislike_comments" name="it_home_list" value="it_dislike_comments" class="form-check-input" {{ $params['it_home_list'] == 'it_dislike_comments' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_dislike_comments">{{ __('FsLang::panel.interaction_it_dislike_comments') }}</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_follow_users" name="it_home_list" value="it_follow_users" class="form-check-input" {{ $params['it_home_list'] == 'it_follow_users' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_follow_users">{{ __('FsLang::panel.interaction_it_follow_users') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_follow_groups" name="it_home_list" value="it_follow_groups" class="form-check-input" {{ $params['it_home_list'] == 'it_follow_groups' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_follow_groups">{{ __('FsLang::panel.interaction_it_follow_groups') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_follow_hashtags" name="it_home_list" value="it_follow_hashtags" class="form-check-input" {{ $params['it_home_list'] == 'it_follow_hashtags' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_follow_hashtags">{{ __('FsLang::panel.interaction_it_follow_hashtags') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_follow_posts" name="it_home_list" value="it_follow_posts" class="form-check-input" {{ $params['it_home_list'] == 'it_follow_posts' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_follow_posts">{{ __('FsLang::panel.interaction_it_follow_posts') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_follow_comments" name="it_home_list" value="it_follow_comments" class="form-check-input" {{ $params['it_home_list'] == 'it_follow_comments' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_follow_comments">{{ __('FsLang::panel.interaction_it_follow_comments') }}</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_block_users" name="it_home_list" value="it_block_users" class="form-check-input" {{ $params['it_home_list'] == 'it_block_users' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_block_users">{{ __('FsLang::panel.interaction_it_block_users') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_block_groups" name="it_home_list" value="it_block_groups" class="form-check-input" {{ $params['it_home_list'] == 'it_block_groups' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_block_groups">{{ __('FsLang::panel.interaction_it_block_groups') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_block_hashtags" name="it_home_list" value="it_block_hashtags" class="form-check-input" {{ $params['it_home_list'] == 'it_block_hashtags' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_block_hashtags">{{ __('FsLang::panel.interaction_it_block_hashtags') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_block_posts" name="it_home_list" value="it_block_posts" class="form-check-input" {{ $params['it_home_list'] == 'it_block_posts' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_block_posts">{{ __('FsLang::panel.interaction_it_block_posts') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="home-it_block_comments" name="it_home_list" value="it_block_comments" class="form-check-input" {{ $params['it_home_list'] == 'it_block_comments' ? 'checked' : '' }}>
                            <label class="form-check-label" for="home-it_block_comments">{{ __('FsLang::panel.interaction_it_block_comments') }}</label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!--interaction_mark_config-->
        <div class="row mt-5">
            <label class="col-lg-2 col-form-label text-lg-end">{{ __('FsLang::panel.interaction_mark_config') }}:</label>
            <!--interaction_mark_content-->
            <div class="col-lg-10 mb-3">
                <ul class="list-group">
                    <li class="list-group-item list-group-item-secondary">{{ __('FsLang::panel.interaction_mark_content') }}</li>
                    <!--user-->
                    <li class="list-group-item">
                        <span class="badge text-bg-light d-block p-3 mb-2 fw-normal fw-semibold fs-8">{{ __('FsLang::panel.user') }}</span>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="user_likers" name="user_likers" value="true" class="form-check-input" {{ $params['user_likers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="user_likers">{{ __('FsLang::panel.interaction_like_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="user_dislikers" name="user_dislikers" value="true" class="form-check-input" {{ $params['user_dislikers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="user_dislikers">{{ __('FsLang::panel.interaction_dislike_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="user_followers" name="user_followers" value="true" class="form-check-input" {{ $params['user_followers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="user_followers">{{ __('FsLang::panel.interaction_follow_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="user_blockers" name="user_blockers" value="true" class="form-check-input" {{ $params['user_blockers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="user_blockers">{{ __('FsLang::panel.interaction_block_it') }}</label>
                        </div>
                        <br>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="user_liker_count" name="user_liker_count" value="true" class="form-check-input" {{ $params['user_liker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="user_liker_count">{{ __('FsLang::panel.interaction_like_it_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="user_disliker_count" name="user_disliker_count" value="true" class="form-check-input" {{ $params['user_disliker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="user_disliker_count">{{ __('FsLang::panel.interaction_dislike_it_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="user_follower_count" name="user_follower_count" value="true" class="form-check-input" {{ $params['user_follower_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="user_follower_count">{{ __('FsLang::panel.interaction_follow_it_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="user_blocker_count" name="user_blocker_count" value="true" class="form-check-input" {{ $params['user_blocker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="user_blocker_count">{{ __('FsLang::panel.interaction_block_it_count') }}</label>
                        </div>
                    </li>
                    <!--group-->
                    <li class="list-group-item">
                        <span class="badge text-bg-light d-block p-3 mb-2 fw-normal fw-semibold fs-8">{{ __('FsLang::panel.group') }}</span>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="group_likers" name="group_likers" value="true" class="form-check-input" {{ $params['group_likers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="group_likers">{{ __('FsLang::panel.interaction_like_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="group_dislikers" name="group_dislikers" value="true" class="form-check-input" {{ $params['group_dislikers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="group_dislikers">{{ __('FsLang::panel.interaction_dislike_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="group_followers" name="group_followers" value="true" class="form-check-input" {{ $params['group_followers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="group_followers">{{ __('FsLang::panel.interaction_follow_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="group_blockers" name="group_blockers" value="true" class="form-check-input" {{ $params['group_blockers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="group_blockers">{{ __('FsLang::panel.interaction_block_it') }}</label>
                        </div>
                        <br>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="group_liker_count" name="group_liker_count" value="true" class="form-check-input" {{ $params['group_liker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="group_liker_count">{{ __('FsLang::panel.interaction_like_it_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="group_disliker_count" name="group_disliker_count" value="true" class="form-check-input" {{ $params['group_disliker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="group_disliker_count">{{ __('FsLang::panel.interaction_dislike_it_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="group_follower_count" name="group_follower_count" value="true" class="form-check-input" {{ $params['group_follower_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="group_follower_count">{{ __('FsLang::panel.interaction_follow_it_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="group_blocker_count" name="group_blocker_count" value="true" class="form-check-input" {{ $params['group_blocker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="group_blocker_count">{{ __('FsLang::panel.interaction_block_it_count') }}</label>
                        </div>
                    </li>
                    <!--hashtag-->
                    <li class="list-group-item">
                        <span class="badge text-bg-light d-block p-3 mb-2 fw-normal fw-semibold fs-8">{{ __('FsLang::panel.hashtag') }}</span>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="hashtag_likers" name="hashtag_likers" value="true" class="form-check-input" {{ $params['hashtag_likers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="hashtag_likers">{{ __('FsLang::panel.interaction_like_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="hashtag_dislikers" name="hashtag_dislikers" value="true" class="form-check-input" {{ $params['hashtag_dislikers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="hashtag_dislikers">{{ __('FsLang::panel.interaction_dislike_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="hashtag_followers" name="hashtag_followers" value="true" class="form-check-input" {{ $params['hashtag_followers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="hashtag_followers">{{ __('FsLang::panel.interaction_follow_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="hashtag_blockers" name="hashtag_blockers" value="true" class="form-check-input" {{ $params['hashtag_blockers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="hashtag_blockers">{{ __('FsLang::panel.interaction_block_it') }}</label>
                        </div>
                        <br>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="hashtag_liker_count" name="hashtag_liker_count" value="true" class="form-check-input" {{ $params['hashtag_liker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="hashtag_liker_count">{{ __('FsLang::panel.interaction_like_it_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="hashtag_disliker_count" name="hashtag_disliker_count" value="true" class="form-check-input" {{ $params['hashtag_disliker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="hashtag_disliker_count">{{ __('FsLang::panel.interaction_dislike_it_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="hashtag_follower_count" name="hashtag_follower_count" value="true" class="form-check-input" {{ $params['hashtag_follower_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="hashtag_follower_count">{{ __('FsLang::panel.interaction_follow_it_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="hashtag_blocker_count" name="hashtag_blocker_count" value="true" class="form-check-input" {{ $params['hashtag_blocker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="hashtag_blocker_count">{{ __('FsLang::panel.interaction_block_it_count') }}</label>
                        </div>
                    </li>
                    <!--post-->
                    <li class="list-group-item">
                        <span class="badge text-bg-light d-block p-3 mb-2 fw-normal fw-semibold fs-8">{{ __('FsLang::panel.post') }}</span>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="post_likers" name="post_likers" value="true" class="form-check-input" {{ $params['post_likers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="post_likers">{{ __('FsLang::panel.interaction_like_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="post_dislikers" name="post_dislikers" value="true" class="form-check-input" {{ $params['post_dislikers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="post_dislikers">{{ __('FsLang::panel.interaction_dislike_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="post_followers" name="post_followers" value="true" class="form-check-input" {{ $params['post_followers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="post_followers">{{ __('FsLang::panel.interaction_follow_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="post_blockers" name="post_blockers" value="true" class="form-check-input" {{ $params['post_blockers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="post_blockers">{{ __('FsLang::panel.interaction_block_it') }}</label>
                        </div>
                        <br>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="post_liker_count" name="post_liker_count" value="true" class="form-check-input" {{ $params['post_liker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="post_liker_count">{{ __('FsLang::panel.interaction_like_it_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="post_disliker_count" name="post_disliker_count" value="true" class="form-check-input" {{ $params['post_disliker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="post_disliker_count">{{ __('FsLang::panel.interaction_dislike_it_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="post_follower_count" name="post_follower_count" value="true" class="form-check-input" {{ $params['post_follower_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="post_follower_count">{{ __('FsLang::panel.interaction_follow_it_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="post_blocker_count" name="post_blocker_count" value="true" class="form-check-input" {{ $params['post_blocker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="post_blocker_count">{{ __('FsLang::panel.interaction_block_it_count') }}</label>
                        </div>
                    </li>
                    <!--comment-->
                    <li class="list-group-item">
                        <span class="badge text-bg-light d-block p-3 mb-2 fw-normal fw-semibold fs-8">{{ __('FsLang::panel.comment') }}</span>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="comment_likers" name="comment_likers" value="true" class="form-check-input" {{ $params['comment_likers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="comment_likers">{{ __('FsLang::panel.interaction_like_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="comment_dislikers" name="comment_dislikers" value="true" class="form-check-input" {{ $params['comment_dislikers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="comment_dislikers">{{ __('FsLang::panel.interaction_dislike_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="comment_followers" name="comment_followers" value="true" class="form-check-input" {{ $params['comment_followers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="comment_followers">{{ __('FsLang::panel.interaction_follow_it') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="comment_blockers" name="comment_blockers" value="true" class="form-check-input" {{ $params['comment_blockers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="comment_blockers">{{ __('FsLang::panel.interaction_block_it') }}</label>
                        </div>
                        <br>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="comment_liker_count" name="comment_liker_count" value="true" class="form-check-input" {{ $params['comment_liker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="comment_liker_count">{{ __('FsLang::panel.interaction_like_it_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="comment_disliker_count" name="comment_disliker_count" value="true" class="form-check-input" {{ $params['comment_disliker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="comment_disliker_count">{{ __('FsLang::panel.interaction_dislike_it_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="comment_follower_count" name="comment_follower_count" value="true" class="form-check-input" {{ $params['comment_follower_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="comment_follower_count">{{ __('FsLang::panel.interaction_follow_it_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="comment_blocker_count" name="comment_blocker_count" value="true" class="form-check-input" {{ $params['comment_blocker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="comment_blocker_count">{{ __('FsLang::panel.interaction_block_it_count') }}</label>
                        </div>
                    </li>
                </ul>
            </div>
            <!--interaction_my_content-->
            <label class="col-lg-2"></label>
            <div class="col-lg-10 mb-3">
                <ul class="list-group">
                    <li class="list-group-item list-group-item-secondary">{{ __('FsLang::panel.interaction_my_content') }} {{ '('.__('FsLang::panel.interaction_my_content_desc').')' }}</li>
                    <li class="list-group-item">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="my_likers" name="my_likers" value="true" class="form-check-input" {{ $params['my_likers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="my_likers">{{ __('FsLang::panel.interaction_my_likers') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="my_dislikers" name="my_dislikers" value="true" class="form-check-input" {{ $params['my_dislikers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="my_dislikers">{{ __('FsLang::panel.interaction_my_dislikers') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="my_followers" name="my_followers" value="true" class="form-check-input" {{ $params['my_followers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="my_followers">{{ __('FsLang::panel.interaction_my_followers') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="my_blockers" name="my_blockers" value="true" class="form-check-input" {{ $params['my_blockers'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="my_blockers">{{ __('FsLang::panel.interaction_my_blockers') }}</label>
                        </div>
                        <br>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="my_liker_count" name="my_liker_count" value="true" class="form-check-input" {{ $params['my_liker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="my_liker_count">{{ __('FsLang::panel.interaction_my_liker_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="my_disliker_count" name="my_disliker_count" value="true" class="form-check-input" {{ $params['my_disliker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="my_disliker_count">{{ __('FsLang::panel.interaction_my_disliker_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="my_follower_count" name="my_follower_count" value="true" class="form-check-input" {{ $params['my_follower_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="my_follower_count">{{ __('FsLang::panel.interaction_my_follower_count') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" id="my_blocker_count" name="my_blocker_count" value="true" class="form-check-input" {{ $params['my_blocker_count'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="my_blocker_count">{{ __('FsLang::panel.interaction_my_blocker_count') }}</label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!--button_save-->
        <div class="row my-3">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <button type="submit" class="btn btn-primary">{{ __('FsLang::panel.button_save') }}</button>
            </div>
        </div>
    </form>

    <!-- Hashtag Regexp Modal -->
    <div class="modal fade" id="hashtagRegexpModal" tabindex="-1" aria-labelledby="hashtagRegexpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">{{ __('FsLang::panel.interaction_hashtag_regexp') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panel.interaction.update.hashtag.regexp') }}" method="post">
                        @csrf
                        @method('put')

                        <div class="input-group">
                            <span class="input-group-text">{{ __('FsLang::panel.interaction_hashtag_format_1') }}</span>
                            <input type="text" class="form-control" name="hashtagRegexp[space]" value="{{ $params['hashtag_regexp']['space'] ?? '' }}">
                        </div>
                        <div class="form-text mb-3 ps-1">{{ __('FsLang::panel.option_default') }}: <code>/#[\p{L}\p{N}\p{M}]+[^\n\p{P}\s]/u</code></div>

                        <div class="input-group">
                            <span class="input-group-text">{{ __('FsLang::panel.interaction_hashtag_format_2') }}</span>
                            <input type="text" class="form-control" name="hashtagRegexp[hash]" value="{{ $params['hashtag_regexp']['hash'] ?? '' }}">
                        </div>
                        <div class="form-text mb-3 ps-1">{{ __('FsLang::panel.option_default') }}: <code>/#[\p{L}\p{N}\p{M}]+[^\n\p{P}]#/u</code></div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{ __('FsLang::panel.button_save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
