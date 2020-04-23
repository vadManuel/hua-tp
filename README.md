<p align="center">
  <img src="media/hua_logo.png" alt="Hua!" width="256px" />
</p>
<br/><br/>

![](https://img.shields.io/static/v1?label=PHP&message=7.3.11&color=a6050d)
![](https://img.shields.io/static/v1?label=phpMyAdmin&message=5.0.1&color=orange)
![](https://img.shields.io/static/v1?label=Apache%20(Unix)&message=2.4.41&color=387f78)
![](https://img.shields.io/static/v1?label=MySQL&message=8.0.19&color=blue)

*Your online toilet paper supplier!*  

### Index
- [Collaborators](#collaborators)
- [Description](#description)
- [Contents](#contents)
- [Working Schemas](#working-schemas)
- [Resources](#resources) 

### Collaborators
<p>
  <a href="https://www.github.com/vadManuel"><img src="https://avatars2.githubusercontent.com/u/7086685?s=400&u=a654bb2b5e4749953357409ed095979211e2daa6&v=4" alt="vadManuel" width="50px" /></a>
  <a href="https://www.github.com/JarvisEQ"><img src="https://avatars0.githubusercontent.com/u/17726904?s=400&u=9acf9b67a85624cacf86f162e97f9ade3c82be34&v=4" alt="JarvisEQ" width="50px" /></a>
  <a href="https://www.github.com/Kinglatour"><img src="https://avatars0.githubusercontent.com/u/48734370?s=400&v=4" alt="Kinglatour" width="50px" /></a>
  <a href="https://www.github.com/JaredSJackson"><img src="https://avatars2.githubusercontent.com/u/47484643?s=400&u=f6f1b3c096c01a827fc478690ce07d384dbfa7d1&v=4" alt="JaredSJackson" width="50px" /></a>
<!--   <a href="https://www.github.com/alex1bu"><img src="https://avatars1.githubusercontent.com/u/51127491?s=400&v=4" alt="alex1bu" width="50px" /></a> -->
  <a href="https://www.github.com/mle1996"><img src="https://avatars2.githubusercontent.com/u/46695586?s=400&u=9fd3d06936b70f91f5354150b34f89da866e9549&v=4" alt="mle1996" width="50px" /></a>
</p>

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
│   ├── calls
│   │   ├── activate.php
│   │   ├── login.php
│   │   ├── logout.php
│   │   └── register.php
│   ├── index.php
│   ├── reset.php
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
└── style
    └── custom.css
</pre>

### Working Schemas
<!-- All this just so I could underline the primary key -->
<table>
<tr>
  <th colspan="7">Users</th>
</tr>
<tr>
  <th align="left">#</th>
  <th align="left">Name</th>
  <th align="left">Type</th>
  <th>Attributes</th>
  <th>Null</th>
  <th align="left">Default</th>
  <th align="left">Extra</th>
</tr>
<tr>
  <td>1</td>
  <td><ins><code>id</code></ins></td>
  <td><code>int</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td>auto increment</td>
</tr>
<tr>
  <td>2</td>
  <td><code>username</code></td>
  <td><code>varchar(50)</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td>3</td>
  <td><code>password</code></td>
  <td><code>varchar(255)</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td>4</td>
  <td><code>email</code></td>
  <td><code>varchar(100)</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td>5</td>
  <td><code>varchar(100)</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><i>empty string</i></td>
  <td></td>
</tr>
<tr>
  <td>6</td>
  <td><code>created_on</code></td>
  <td><code>timestamp</code></td>
  <td></td>
  <td><code>false</code></td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td>7</td>
  <td><code>address_1</code></td>
  <td><code>varchar(100)</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td>8</td>
  <td><code>address_2</code></td>
  <td><code>varchar(100)</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td>9</td>
  <td><code>zip</code></td>
  <td><code>varchar(100)</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td>10</td>
  <td><code>city</code></td>
  <td><code>varchar(100)</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td>11</td>
  <td><code>state</code></td>
  <td><code>varchar(100)</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td>12</td>
  <td><code>card_name</code></td>
  <td><code>varchar(100)</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td>13</td>
  <td><code>card_number</code></td>
  <td><code>varchar(100)</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <td>14</td>
  <td><code>card_exp</code></td>
  <td><code>date</code></td>
  <td></td>
  <td><code>false</code></td>
  <td><code>none</code></td>
  <td></td>
</tr>
<tr>
  <th colspan="6">Products</th>
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

### Resources
- [PHP Router](https://www.taniarascia.com/the-simplest-php-router/)
- [Project Description](http://www.cs.ucf.edu/~kienhua/classes/COP4710/Projects/ProjDescription.pdf)
- [Markdown is dumb and apparently <ins>this</ins> needs an html tag](https://github.com/jch/html-pipeline/blob/master/lib/html/pipeline/sanitization_filter.rb)
- [Job Scheduling](https://stackoverflow.com/questions/6711366/how-can-i-trigger-events-in-a-future-time-in-php)
- [Email Trigger](https://stackoverflow.com/questions/10755469/send-e-mail-from-a-trigger)
