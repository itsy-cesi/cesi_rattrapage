<?php use App\Http\Controllers\PostController; ?>
<div class="card mx-auto my-5" message-id="{{ $value['id'] }}"
                        share-link="{{ route('post', $value['id']) }}">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between">
                                <a href="{{ '/user/' . $value['author']['name'] }}"
                                    class="d-flex align-items-center link-dark text-decoration-none">
                                    <img src="{{ $value['author']['picture'] }}"
                                        alt="" width="32" height="32" class="rounded-circle me-2" />
                                    <strong>{{ $value['author']['name'] }}</strong>
                                </a>
                                <div class="d-flex align-items-center">
                                    <small>{{ $value['post_date'] }}</small>
                                    @if ($value['author']['name'] == (Auth::user()->name ?? ''))
                                        <div class="dropdown">
                                            <a class="btn" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item bg-danger text-white" action="delete_post"
                                                        target="{{ route('api.delete_post') }}"
                                                        post_id="{{ $value['id'] }}"><i class="fa fa-trash"
                                                            aria-hidden="true"></i><span class="ms-3">Delete
                                                            post</span></a></li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </h5>
                            <p class="card-text">{{ $value['message'] }}</p>
                            <?php
                            $postController = new PostController();

                            if ($value['parent'] != null && (!isset($id) || (($id ?? -1) == $value['id']))):

                            $parent = $postController->show($value['parent']);
                            ?>
                            <b>Response to:</b>
                            <div class="alert alert-primary" onclick="document.location = '{{ route('post', $parent['id']) }}'" role="alert">
                                <span
                                    class="d-flex align-items-center link-dark text-decoration-none">
                                    <img src="{{ $parent['author']['picture'] }}"
                                        alt="" width="32" height="32" class="rounded-circle me-2" />
                                    <strong>{{ $parent['author']['name'] }}</strong>
                                </span>
                                <small>{{ $parent['post_date'] }}</small>
                                <p class="p-3 pb-0">{{ $parent['message'] }}</p>
                            </div>
                            <?php endif; ?>
                            <form action="#" method="get" type="post_action">
                                <ul class="list-unstyled d-flex w-50 ms-3">
                                    <li class="me-3">
                                        <a class="text-decoration-none d-flex {{ $value['is_liked'] ? 'text-danger' : 'text-dark' }}"
                                            action="post_button" name="like">
                                            <i class="fa fa-heart" aria-hidden="true"></i>
                                            <span class="ms-2">Like</span>
                                            <span name="count_like"
                                                class="ms-2 badge text-bg-secondary">{{ $value['likes'] }}</span>
                                        </a>
                                    </li>
                                    <li class="m-3"></li>
                                    <li class="me-3">
                                        <a class="text-decoration-none d-flex text-dark" action="post_button"
                                            name="share">
                                            <i class="fa fa-share" aria-hidden="true"></i>
                                            <span class="ms-2">Share</span>
                                        </a>
                                    </li>
                                    <li class="m-3"></li>
                                    <li class="me-3">
                                        <a class="text-decoration-none d-flex text-dark" action="post_button"
                                            name="comment">
                                            <i class="fa fa-comment" aria-hidden="true"></i>
                                            <span class="ms-2">Comment</span>
                                            <span name="count_like"
                                                class="ms-2 badge text-bg-secondary">{{ $value['comments'] ?? count($value['comment']) }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
