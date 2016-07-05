<?php


if (!function_exists('bw_path')) {
    function bw_path($path = '')
    {
        return app('bookworm')->basePath().($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('project_url')) {
    function project_url() {
        return app('request')->project->url();
    }
}

if (!function_exists('project_redirect')) {
    function project_redirect() {
        return redirect(app('request')->project->url());
    }
}

if (!function_exists('get_gravatar')) {
    function get_gravatar($email, $size = null)
    {
        $email = md5(strtolower(trim($email)));
        $url = 'https://www.gravatar.com/avatar/';
        $params = [];

        if ($size) {
            $params['s'] = $size;
        }

        return $url.$email.http_build_query($params);
    }
}

if (!function_exists('array_values_keys')) {
    function array_values_keys(array $array)
    {
        return array_combine($array, $array);
    }
}
