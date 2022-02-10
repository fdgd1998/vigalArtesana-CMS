# **LICENSE**
Copyright by Francisco Gálvez

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

## ViGal Artesana CMS
This is a small, custom CMS developed from scratch for my family's carprenty and restoration company.

See the project on vigalartesana.es

The main purpose of this CMS is to be simple, lightweight and without any unnecessary features that may decrease site performance.

- Programming languages: JS, PHP and SQL.
- Markup languages: HTML.
- Styles languages: CSS.
- Frameworks: Bootstrap, jQuery.
- Web development techniques: AJAX.

### Features:
- Fully featured site control panel.
- Encryption of sensible data stored in the database.
- Gallery system organized by categories.
- Customizable company info.
- In-site contact form.
- Search Engine Optimization.
- Under construction / maintenance website template.

### Future features:
- Blog system.(*)

### Broken features (might be fixed in the future):
- User management (creation, deletion, edition, profiles, privileges).
- Account password recovery by unique token sent via email.

NOTE: Features marked with (*) are in the works.

## Setup
There's a default key for data encryption in database in cryptograhic_key.php. Change this key later on if you plan to upload the code to any hosting.

Control panel access user is "admin" and password "admin", without the quotes.

Remember to change your settings in connection.php and email_settings.php after your have exported the database in your machine.

In order to make everything work, you'll need to do the following.

Move cryptograhpic_key.php, connection.php and email_settings.php outside your website's root folder (at same directory level). This is because theese files have to be in a non public accesible location.

Copy all the content inside public_html into the root of your website's root folder.

You may see some missing elements until you populate the website with contents.
