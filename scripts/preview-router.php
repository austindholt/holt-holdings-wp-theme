<?php
/** Local template preview only. No WordPress database, mail, or production writes. */
define('ABSPATH', __DIR__ . '/');
$route = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
if (PHP_SAPI !== 'cli-server') { http_response_code(404); exit; }
$theme = dirname(__DIR__);
if (str_starts_with($route, 'assets/') || $route === 'style.css') {
 $file = $theme . '/' . $route;
 if (!is_file($file) || str_contains($route, '..')) { http_response_code(404); exit; }
 header('Content-Type: ' . (str_ends_with($file, '.css') ? 'text/css' : (str_ends_with($file, '.js') ? 'text/javascript' : (str_ends_with($file, '.png') ? 'image/png' : 'image/jpeg')))); readfile($file); exit;
}
if ($route === 'wp-admin/admin-post.php') { http_response_code(405); exit('Visual preview only: submissions are disabled.'); }
function add_action(...$args) {} function add_filter(...$args) {} function remove_action(...$args) {}
function get_template_directory() { global $theme; return $theme; }
function get_template_directory_uri() { return 'http://localhost:8787'; }
function home_url($path = '/') { return 'http://localhost:8787' . $path; }
function get_permalink() { global $route; return home_url('/' . ($route ? $route . '/' : '')); }
function is_front_page() { global $route; return !$route; } function is_home() { return false; }
function is_page() { return !is_front_page(); } function is_singular() { return true; }
function get_queried_object_id() { return 1; } function get_post_field(...$args) { global $route; return $route; }
function get_theme_mod($key, $default = '') { return $default; }
function esc_html($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function esc_attr($s) { return esc_html($s); } function esc_url($s) { return esc_html($s); }
function __($s, ...$args) { return $s; } function esc_html__($s, ...$args) { return esc_html($s); }
function esc_html_e($s, ...$args) { echo esc_html($s); } function esc_attr_e($s, ...$args) { echo esc_attr($s); }
function wp_parse_url($s, $part = -1) { return parse_url($s, $part); }
function sanitize_email($s) { return filter_var($s, FILTER_SANITIZE_EMAIL); } function is_email($s) { return filter_var($s, FILTER_VALIDATE_EMAIL); }
function sanitize_text_field($s) { return strip_tags($s); } function sanitize_key($s) { return preg_replace('/[^a-z0-9_-]/', '', strtolower($s)); }
function wp_json_encode($s, $flags = 0) { return json_encode($s, $flags); }
function current_user_can(...$args) { return false; }
function wp_get_theme() { return new class { function get($s) { global $theme; preg_match('/^Version:\s*(\S+)/m', file_get_contents($theme . '/style.css'), $m); return $m[1]; } }; }
function get_bloginfo($key) { return ['name'=>'Holt Holdings', 'charset'=>'UTF-8'][$key] ?? ''; }
function bloginfo($key) { echo get_bloginfo($key); }
function language_attributes() { echo 'lang="en-US"'; } function body_class() { echo 'class="local-preview"'; }
function wp_body_open() {} function has_custom_logo() { return true; }
function the_custom_logo() { echo '<a class="custom-logo-link" href="/"><img class="custom-logo" src="/assets/images/holt-holdings-logo.jpeg" width="54" height="54" alt="Holt Holdings LLC"></a>'; }
function wp_head() {
 $meta = holt_holdings_page_meta(); echo '<title>' . esc_html($meta['title'] ?? 'Holt Holdings') . '</title><meta name="robots" content="noindex,nofollow">';
 holt_holdings_canonical_url(); holt_holdings_meta_tags(); holt_holdings_structured_data();
 echo '<link rel="stylesheet" href="/style.css">';
}
function wp_footer() { echo '<script src="/assets/js/navigation.js"></script><script>document.querySelectorAll("form").forEach(function(f){f.addEventListener("submit",function(e){e.preventDefault();alert("Visual preview only. Form submissions are disabled.");});});</script>'; }
function admin_url($s) { return home_url('/wp-admin/' . $s); }
function wp_nonce_field(...$args) { echo '<input type="hidden" name="holt_merch_nonce" value="preview-only">'; }
function absint($s) { return abs((int)$s); } function wp_unslash($s) { return $s; }
function get_header() { global $theme; include $theme . '/header.php'; }
function get_footer() { global $theme; include $theme . '/footer.php'; }
require $theme . '/functions.php';
$pages = holt_holdings_site_pages();
if ($route && !isset($pages[$route])) { http_response_code(404); exit('Page not found'); }
include $theme . '/' . ($route ? 'page-' . $route . '.php' : 'front-page.php');
