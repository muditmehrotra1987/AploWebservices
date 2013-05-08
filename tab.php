<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script>
$(document).ready(function(){
$('#tabs div').hide();
$('#tabs div:first').show();
$('#tabs ul li:first').addClass('active');
 
$('#tabs ul li a').click(function(){
$('#tabs ul li').removeClass('active');
$(this).parent().addClass('active');
var currentTab = $(this).attr('href');
$('#tabs div').hide();
$(currentTab).show();
return false;
});
});
</script>
</head>

<body>

<div style="width:960px; height:300px; border:1px solid #000000;">

<div style="width:300px; height:300px; position:absolute; float:left; border:1px solid #000000;">
	<h1>Div 1</h1>
    <div id="tabs">
   <ul>
     <li><a href="#tab-1">This is Tab 1</a></li>
     <li><a href="#tab-2">Tab Two</a></li>
     <li><a href="#tab-3">Tab Three</a></li>
     <li><a href="#tab-4">Tab Four</a></li>
   </ul>
   <div id="tab-1">
     <h3>This is a really simple tabbed interface</h3>
     <p><img src="http://papermashup.com/demos/jquery-gallery/images/t1.png" width="120" height="120" class="thumbs"/> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur enim. Nullam id ligula in nisl tincidunt feugiat. Curabitur eu magna porttitor ligula bibendum rhoncus. Etiam dignissim. Duis lobortis porta risus. Quisque velit metus, dignissim in, rhoncus at, congue quis, mi. Praesent vel lorem. Suspendisse ut dolor at justo tristique dapibus. Morbi erat mi, rutrum a, aliquam nec, mattis semper, leo. Maecenas blandit risus vitae quam. Vivamus ut odio. Pellentesque mollis arcu nec metus. Nullam bibendum scelerisque turpis. Aliquam erat volutpat. <br/>
       <a href="http://feeds2.feedburner.com/AshleyFord-Papermashupcom">Subscribe to my feed here</a> </p>
   </div>
   <div id="tab-2">
     <h3>Tab 2</h3>
     <p><img src="http://papermashup.com/demos/jquery-gallery/images/t2.png" width="120" height="120" class="thumbs"/> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur enim. Nullam id ligula in nisl tincidunt feugiat. Curabitur eu magna porttitor ligula bibendum rhoncus. Etiam dignissim. Duis lobortis porta risus. Quisque velit metus, dignissim in, rhoncus at, congue quis, mi. Praesent vel lorem. Suspendisse ut dolor at justo tristique dapibus. Morbi erat mi, rutrum a, aliquam nec <br/>
       <a href="http://feeds2.feedburner.com/AshleyFord-Papermashupcom">Subscribe to my feed here</a></p>
   </div>
   <div id="tab-3">
     <h3>Tab 3</h3>
     <p><img src="http://papermashup.com/demos/jquery-gallery/images/t3.png" width="120" height="120" class="thumbs"/> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur enim. Nullam id ligula in nisl tincidunt feugiat. Curabitur eu magna porttitor ligula bibendum rhoncus. Etiam dignissim. Duis lobortis porta risus. Quisque velit metus, dignissim in, rhoncus at, congue quis, mi. Praesent vel lorem. Suspendisse ut dolor at justo tristique dapibus. Morbi erat mi, rutrum a, aliquam nec, mattis semper, leo. Maecenas blandit risus vitae quam. Vivamus ut odio.<br/>
       <a href="http://feeds2.feedburner.com/AshleyFord-Papermashupcom">Subscribe to my feed here</a></p>
   </div>
   <div id="tab-4">
     <h3>Tab 4</h3>
     <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur enim. Nullam id ligula in nisl tincidunt feugiat. Curabitur eu magna porttitor ligula bibendum rhoncus. Etiam dignissim. Duis lobortis porta risus. Quisque velit metus, dignissim in, rhoncus at, congue quis, mi. Praesent vel lorem. Suspendisse ut dolor at justo tristique dapibus. Morbi erat mi, rutrum a, aliquam nec, mattis semper, leo. Maecenas blandit risus vitae quam. Vivamus ut odio. Pellentesque mollis arcu nec metus.<br/>
       <a href="http://feeds2.feedburner.com/AshleyFord-Papermashupcom">Subscribe to my feed here</a></p>
   </div>
 </div>

</div>

<div style="margin:0 0 0 19em; width:300px; height:200; position:relative; float:left; border:1px solid #000000;">
	<h1>Div 2</h1>
</div>

</div>

</body>
</html>
