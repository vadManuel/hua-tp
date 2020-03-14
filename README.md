<p align="center">
    <img src="media/hua_logo.png" alt="Hua!" width="256px" />
</p>
<br/><br/>


![](https://img.shields.io/static/v1?label=PHP&message=7.3.11&color=a6050d)
![](https://img.shields.io/static/v1?label=phpMyAdmin&message=7.3.11&color=orange)
![](https://img.shields.io/static/v1?label=Apache%20(Unix)&message=2.4.41&color=387f78)
![](https://img.shields.io/static/v1?label=MySQL&message=8.0.19&color=blue)

*A plain old Amazon ripoff!*
<br><br>

### Description
We get to create an online discount store by utilizing what we learned in class. Nevermind those pesky new-ish technology like [Boostrap](https://getbootstrap.com) or literally any Javascript library. I mean... who needs those! 

### Contents
<pre>
.
├── .htaccess
├── index.php
├── 404.html
├── manifest.json
├── authentication
│   ├── activate.php
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── register.php
│   └── signup.php
├── main
│   ├── index.php
│   └── profile.php
├── utility
│   ├── buildMessage.php
│   └── util.php
├── media
│   ├── favicon.png
│   └── hua_logo.png
└── css
    └── custom.css
</pre>

### Working Schemas
<!-- All this just so I could underline the primary key -->
<table>
<tr>
  <th colspan="6">Users</th>
</tr>
<tr>
  <th>Name</th><th>Type</th><th>Attributes</th>
  <th>Null</th><th>Default</th><th>Extra</th>
</tr>
<tr>
  <td><ins><code>id</code></ins></td>
  <td><code>int</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td>auto increment</td>
</tr>
<tr>
  <td><code>username</code></td>
  <td><code>varchar(50)</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td><code>password</code></td>
  <td><code>varchar(255)</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td><code>email</code></td>
  <td><code>varchar(100)</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td><code>activation_code</code></td>
  <td><code>varchar(100)</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><i>empty string</i></td>
  <td></td>
</tr>
<tr>
  <td><code>last_login</code></td>
  <td><code>timestamp</code></td>
  <td></td>
  <td><code>false</code></td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td><code>created_on</code></td>
  <td><code>timestamp</code></td>
  <td></td>
  <td><code>false</code></td>
  <td></td>
  <td></td>
</tr>
<tr>
  <th colspan="6">Product</th>
</tr>
<tr>
  <th>Name</th><th>Type</th><th>Attributes</th>
  <th>Null</th><th>Default</th><th>Extra</th>
</tr>
<tr>
  <td><ins><code>id</code></ins></td>
  <td><code>int</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td>auto increment</td>
</tr>
<tr>
  <td><code>name</code></td>
  <td><code>varchar(100)</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td><code>description</code></td>
  <td><code>text</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td><code>price</code></td>
  <td><code>float</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td><code>stock</code></td>
  <td><code>int</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td><code>updated_on</code></td>
  <td><code>timestamp</code></td>
  <td>triggers on update</td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td><code>created_on</code></td>
  <td><code>timestamp</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
</table>

<br>

I'm currently only hosting it locally. So, just let me know if you need help setting it up.


### Resources
- [PHP Router](https://www.taniarascia.com/the-simplest-php-router/)
- [Project Description](http://www.cs.ucf.edu/~kienhua/classes/COP4710/Projects/ProjDescription.pdf)
- [Markdown is dumb and apparently <ins>this</ins> needs an html tag](https://github.com/jch/html-pipeline/blob/master/lib/html/pipeline/sanitization_filter.rb)