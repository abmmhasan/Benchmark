#!/usr/bin/env sh
route_static="GET 200 $base/$fw/asset/public/index.php/hello/index"
route_dynamic_first="GET 200 $base/$fw/asset/public/index.php/42/hello/index"
route_dynamic_middle="GET 200 $base/$fw/asset/public/index.php/hello/42/index"
route_dynamic_last="GET 200 $base/$fw/asset/public/index.php/hello/index/42"
route_multiple="GET 200 $base/$fw/asset/public/index.php/hello/pair/42/84"
route_static_precedence="GET 200 $base/$fw/asset/public/index.php/hello/benchmark/fixed"
route_not_found="GET 404 $base/$fw/asset/public/index.php/benchmark/not-found"
route_method_not_allowed="POST 405 $base/$fw/asset/public/index.php/hello/index"
