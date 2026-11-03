Minneapolis Gem (Carl Weimer) - static HTML version
===================================================

Upload the CONTENTS of this folder (including the hidden .htaccess file) to the web root of
www.minneapolisgem.com, or to any subfolder for a staging preview. All links are relative.

Pages (same URLs as the live site)
  /  /about/  /services/  /faq/  /resources/  /contact/
  /blog/ and /project/ (these are empty "No Results Found" pages on the live site too)
/about, /services and /contact without the trailing slash open the same pages.

Contact forms
-------------
Both kinds of form on the site now post to send.php (needs PHP):
- the custom form on the home page and /contact/ (keeps its math question)
- the Divi forms on /about/, /services/, /faq/ and /resources/ (keeps Divi's math question
  and required fields, checked in the browser)
Messages go to carlweimer9@gmail.com (the address shown on the site); change $to in send.php
to use another address. A hidden honeypot field adds basic spam protection.
The search box opens a Google search limited to minneapolisgem.com.

Noindex (staging)
-----------------
Every page has <meta name="robots" content="noindex, nofollow" /> and .htaccess sends an
X-Robots-Tag: noindex, nofollow header, so search engines will not index this copy.
BEFORE GOING LIVE on the real domain: remove that meta line from each page and delete the
"BEGIN noindex ... END noindex" block from .htaccess, or the site will drop out of Google.
