<?php 
include 'header.php'); 
?>

<body>
<div id="container">
	<section id="abovefold">
		<div id="abovefold-container">
			<div id="title"><h1>Clean lists. Higher Response Rates.</h1></div>
			<div id="leftdiv">
				<img src="img/icons/svg/clipboard.svg" alt="Clipboard">
				<p>Welcome to <br /><strong>ListBadger</strong></p>
			</div>
			<div id="rightdiv">
				 <div class="login-form">
            <div class="form-group">
              <input type="text" class="form-control login-field" value="" placeholder="Yo! What's your name? " id="login-name" autocomplete="off" style="">
              <label class="login-field-icon fui-user" for="login-name"></label>
            </div>

            <div class="form-group">
              <input type="text" class="form-control login-field" value="" placeholder="Where should we email your list?" id="email" autocomplete="off" style="">
              
                <br />
                 <a class="btn btn-primary btn-lg btn-block" href="#">Upload</a>
            <a class="login-link" href="#">Lost your password?</a>
            </div>
        </div>
           
          </div>
			</div>
		</div>
	</section>

	<section id="belowfold">
    <div id="belowfold-container">
      <div style="float:left; width:150px; margin-right:20%;">
          <img src="img/icons/svg/clocks.svg" alt="Watches" style="margin-bottom:15px;">
        <p>Upload your CSV</p>
      </div>
      <div style="float:left; width:150px; margin-right:20%">
          <img src="img/icons/svg/retina.svg" alt="Retina" style="margin-bottom:15px;">
        <p>Our Honeybadgers clean it up</p>
      </div>
      <div style="float:left; width:150px;">
          <img src="img/icons/svg/mail.svg" alt="Mail" style="margin-bottom:15px;">
       <p>We email you a clean list</p> 
      </div>
    </div>
	</section>
    
<?php include('footer.php'); ?>
  