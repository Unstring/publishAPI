<?php

$routes = [
  '/user/create'                      => 'UserService@create',
  '/user/login'                       => 'UserService@login',
  '/user/update'                      => 'UserService@update',
  '/user'                             => 'UserService@list',
  '/user/forgotpass'                  => 'UserService@changepassword',
  '/user/getotp'                      => 'UserService@getotp',
  '/user/dashboard'                   => 'UserService@dashboard',
  '/user/uploadAvatar'                => 'UserService@uploadAvatar',

  '/'                                 => 'HomeService@index',

  '/feed/post'                        => 'FeedService@post',
  '/feedbycount/{id}'                        => 'FeedService@index',
  '/feedbycountandoptionaluser/{id}'                        => 'FeedService@list',
  '/react/{id}/{id}'                  => 'ReactionService@reactPost',
  '/'                                 => 'HomeService@index',

  '/test/{id}/{id}/{id}'              => 'TestService@test',
  '/test/{id}/{id}'                   => 'TestService@test',
  '/test/{id}'                        => 'TestService@test',
];