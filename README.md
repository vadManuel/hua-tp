# Hua
### A plain old Amazon ripoff
### ~~A good for nothing online store~~

## Working Schemas
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

### Tech Used
- PHP 7.3.11
- phpMyAdmin 5.0.1
- Apache/2.4.41
- MySQL 8.0.19

I'm currently only hosting it locally. So, just let me know if you need help setting it up.

[Markdown is dumb and apparently <ins>this</ins> needs an html tag](https://github.com/jch/html-pipeline/blob/master/lib/html/pipeline/sanitization_filter.rb)