<?php include('E_header.php') ?> 

<!-- content -->
	<section id="content">
		<div class="wrapper">
			<div class="pad">
				<div class="wrapper">
					<article class="col1"><h2>Contact form</h2></article>
					<article class="col2 pad_left1"><h2>Contact us</h2></article>
				</div>
			</div>
			<div class="box pad_bot1">
				<div class="pad marg_top">
					<article class="col1">
						<form id="ContactForm" action="">
							<div>
								<div class="wrapper">
									<div class="bg"><input class="input" type="text"></div>Name:
								</div>
								<div class="wrapper">
									<div class="bg"><input class="input" type="text"></div>Email:
								</div>
								<div class="wrapper">
									<div class="bg2"><textarea cols="1" rows="1"></textarea></div>Message:
								</div>
								<a href="#" class="button" onclick="document.getElementById('ContactForm').submit()">send</a>
								<a href="#" class="button" onclick="document.getElementById('ContactForm').reset()">clear</a>
							</div>
						</form>
					</article>
					<article class="col2 pad_left1">
						<div class="wrapper">
							<p class="cols pad_bot3">
								<strong>
									Country:<br>
									City:<br>
									Telephone:<br>
									Email:
								</strong>
							</p>
							<p class="pad_bot3">
								USA<br>
								San Diego<br>
								+354 5635600<br>
								<a href="mailto:">smartbiz@mail.com</a>
							</p>
						</div>
						<h2>Miscellaneous Info</h2>
						<p class="pad_bot3">Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusantaque earum rerum hic.</p>
					</article>
				</div>
			</div>
			<div class="wrapper pad_bot4">
				<ul class="banners">
					<li>
						<a href="#"><img src="images/page1_img1.jpg" alt=""></a>
						<div class="pad">
							<p class="font1">Company History</p>
							<p>Lorem ipsum doloamet consect etuer adipiscing.</p>
							<a href="#" class="marker"></a>
						</div>
					</li>
					<li>
						<a href="#"><img src="images/page1_img2.jpg" alt=""></a>
						<div class="pad">
							<p class="font1">Our Capabilities</p>
							<p>Sed ut perspiciatis unde omnis iste naturror voluptatem.</p>
							<a href="#" class="marker"></a>
						</div>
					</li>
					<li>
						<a href="#"><img src="images/page1_img3.jpg" alt=""></a>
						<div class="pad">
							<p class="font1">Where We Deliver</p>
							<p>Nam libero tempore cum soluta nobis est eligendi optio.</p>
							<a href="#" class="marker"></a>
						</div>
					</li>
					<li>
						<a href="#"><img src="images/page1_img4.jpg" alt=""></a>
						<div class="pad">
							<p class="font1">Operations Consulting</p>
							<p>Temporibus autem quibusdam et aut officiis.</p>
							<a href="#" class="marker"></a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</section>
<!-- / content -->
<?php include('E_footer.php') ?> 
