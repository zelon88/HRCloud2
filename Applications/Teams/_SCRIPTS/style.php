<?php
    header("Content-type: text/css; charset: UTF-8");
?>
.dropdown {
    float: right;
    position: relative;
    display: inline-block;
    
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    right: 0;
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown a:hover {background-color: #f1f1f1}

.show {display:block;}

<?php 
if ($ColorScheme == '0' or $ColorScheme == '1') { ?>
.dropbtn:hover {
    background-color: #1B3656;
}
.dropbtn {
    background-color: #444;
    color: white;
    padding: 16px;
    font-family: 'Arial', 'Arial';
    font-size: 1.2em;
    border: none;
    cursor: pointer;
}

.nav ul {
  list-style: none;
  background-color: #444; /*Dark Grey*/
  text-align: center;
  padding: 0;
  margin: 0;
}
.nav li {
  font-family: 'Arial', 'Arial';
  font-size: 1.2em;
  line-height: 40px;
  height: 40px;
  border-bottom: 1px solid #888; /*Light Grey*/
}
.nav a {
  text-decoration: none;
  color: #fff;
  display: block;
  transition: .3s background-color;
}
.nav a:hover {
  background-color: #1B3656; /*Very Light Grey*/
}
.nav a.active {
  background-color: #fff; /*White*/
  color: #444; /*Dark Grey*/
  cursor: default;
}
@media screen and (min-width: 600px) {
  .nav li {
    width: 120px;
    border-bottom: none;
    height: 50px;
    line-height: 50px;
    font-size: 1.4em;
  }
  /* Option 1 - Display Inline */
  .nav li {
    display: inline-block;
    margin-right: -4px;
  }

<?php } 
if ($ColorScheme == '2') { ?>
.dropbtn:hover {
    background-color: #830606;
}
.dropbtn {
    background-color: #444;
    color: white;
    padding: 16px;
    font-family: 'Arial', 'Arial';
    font-size: 1.2em;
    border: none;
    cursor: pointer;
}

.nav ul {
  list-style: none;
  background-color: #444; /*Dark Grey*/
  text-align: center;
  padding: 0;
  margin: 0;
}
.nav li {
  font-family: 'Arial', 'Arial';
  font-size: 1.2em;
  line-height: 40px;
  height: 40px;
  border-bottom: 1px solid #444; /*Dark Grey*/
}
.nav a {
  text-decoration: none;
  color: #fff;
  display: block;
  transition: .3s background-color;
}
.nav a:hover {
  background-color: #830606; /*Red2*/
}
.nav a.active {
  background-color: #830606; /*Red2*/
  color: #444; /*Dark Grey*/
  cursor: default;
}
@media screen and (min-width: 600px) {
  .nav li {
    width: 120px;
    border-bottom: none;
    height: 50px;
    line-height: 50px;
    font-size: 1.4em;
  }
  /* Option 1 - Display Inline */
  .nav li {
    display: inline-block;
    margin-right: -4px;
  }

<?php }
if ($ColorScheme == '3') { ?>
.dropbtn:hover {
    background-color: #12a72b;
}
.dropbtn {
    background-color: #444;
    color: white;
    padding: 16px;
    font-family: 'Arial', 'Arial';
    font-size: 1.2em;
    border: none;
    cursor: pointer;
}

.nav ul {
  list-style: none;
  background-color: #444;
  text-align: center;
  padding: 0;
  margin: 0;
}
.nav li {
  font-family: 'Arial', 'Arial';
  font-size: 1.2em;
  line-height: 40px;
  height: 40px;
  border-bottom: 1px solid #888;
}
.nav a {
  text-decoration: none;
  color: #fff;
  display: block;
  transition: .3s background-color;
}
.nav a:hover {
  background-color: #12a72b; /*Dark Green*/
}
.nav a.active {
  background-color: #fff;
  color: #444;
  cursor: default;
}

<?php }
if ($ColorScheme == '4') { ?>
.dropbtn:hover {
    background-color: #830606;
}
.dropbtn {
    background-color: #444;
    color: white;
    padding: 16px;
    font-family: 'Arial', 'Arial';
    font-size: 1.2em;
    border: none;
    cursor: pointer;
}

.nav ul {
  list-style: none;
  background-color: #444; /*Dark Grey*/
  text-align: center;
  padding: 0;
  margin: 0;
}
.nav li {
  font-family: 'Arial', 'Arial';
  font-size: 1.2em;
  line-height: 40px;
  height: 40px;
  border-bottom: 1px solid #444; /*Dark Grey*/
}
.nav a {
  text-decoration: none;
  color: #fff;
  display: block;
  transition: .3s background-color;
}
.nav a:hover {
  background-color: #830606; /*Red2*/
}
.nav a.active {
  background-color: #830606; /*Red2*/
  color: #444; /*Dark Grey*/
  cursor: default;
}
@media screen and (min-width: 600px) {
  .nav li {
    width: 120px;
    border-bottom: none;
    height: 50px;
    line-height: 50px;
    font-size: 1.4em;
  }
  /* Option 1 - Display Inline */
  .nav li {
    display: inline-block;
    margin-right: -4px;
  }

<?php }
if ($ColorScheme == '5') { ?>
.dropbtn:hover {
    background-color: #1B3656;
}
.dropbtn {
    background-color: #444;
    color: white;
    padding: 16px;
    font-family: 'Arial', 'Arial';
    font-size: 1.2em;
    border: none;
    cursor: pointer;
}
.nav ul {
  list-style: none;
  background-color: #444;
  text-align: center;
  padding: 0;
  margin: 0;
}
.nav li {
  font-family: 'Arial', 'Arial';
  font-size: 1.2em;
  line-height: 40px;
  height: 40px;
  border-bottom: 1px solid #888;
}
.nav a {
  text-decoration: none;
  color: #fff;
  display: block;
  transition: .3s background-color;
}
.nav a:hover {
  background-color: #1B3656;
}
.nav a.active {
  background-color: #fff;
  color: #444;
  cursor: default;
}
@media screen and (min-width: 600px) {
  .nav li {
    width: 120px;
    border-bottom: none;
    height: 50px;
    line-height: 50px;
    font-size: 1.4em;
  }
  /* Option 1 - Display Inline */
  .nav li {
    display: inline-block;
    margin-right: -4px;
  }

<?php } ?>