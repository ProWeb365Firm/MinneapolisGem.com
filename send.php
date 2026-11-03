<?php
/**
 * Contact form handler for the static Minneapolis Gem (Carl Weimer) site.
 * Handles both forms on the site:
 *   - the custom contact form (home page and /contact/)
 *   - the Divi contact forms (/about/, /services/, /faq/, /resources/)
 * Replaces WordPress/Divi form processing. Uses PHP mail().
 */

$to       = 'carlweimer9@gmail.com';
$fromAddr = 'no-reply@minneapolisgem.com';

// Pages a form may send the visitor back to (relative to this file).
$allowedReturns = ['./', 'about/', 'services/', 'faq/', 'resources/', 'contact/'];
$return = in_array($_POST['_return'] ?? '', $allowedReturns, true) ? $_POST['_return'] : './';
function back($return, $ok) { header('Location: ' . $return . '?sent=' . ($ok ? '1' : '0')); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ./'); exit; }

// Honeypot: real visitors never fill this hidden field.
if (!empty($_POST['website_url'])) back($return, true);

function clean_line($v) { return trim(str_replace(["\r", "\n", "%0a", "%0d"], ' ', (string)$v)); }

if (isset($_POST['et_pb_contact_name_0'])) {
    // Divi contact form (the math question is checked in the browser)
    $name    = clean_line($_POST['et_pb_contact_name_0'] ?? '');
    $email   = clean_line($_POST['et_pb_contact_email_0'] ?? '');
    $phone   = clean_line($_POST['et_pb_contact_phone_0'] ?? '');
    $message = trim((string)($_POST['et_pb_contact_message_0'] ?? ''));
} else {
    // Custom contact form, with its own math question
    $name    = clean_line($_POST['name'] ?? '');
    $email   = clean_line($_POST['email'] ?? '');
    $phone   = clean_line($_POST['phone'] ?? '');
    $message = trim((string)($_POST['message'] ?? ''));
    if (trim((string)($_POST['captcha'] ?? '')) !== trim((string)($_POST['captcha_answer'] ?? ''))) back($return, false);
}

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) back($return, false);

$page = $return === './' ? 'Home' : rtrim($return, '/');
$body  = "New message from the website ({$page} page)\n\n";
$body .= "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\n\nMessage:\n{$message}\n";
$body .= "\n--\nSent from minneapolisgem.com";

$headers  = "From: Minneapolis Gem Website <{$fromAddr}>\r\n";
$headers .= "Reply-To: {$name} <{$email}>\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$ok = mail($to, 'Website message from ' . $name, $body, $headers, '-f' . $fromAddr);
back($return, $ok);
