<?php

namespace template;

function social_buttons(){
	echo '
		<ul class="social faso-social-icons">
			<li>
				<a href="https://www.facebook.com/tonyaramseyart/" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a>
			</li>
			<li>
				<a href="https://www.instagram.com/tonyaramseyart/" title="Instagram" target="_blank"><i class="fa fa-instagram"></i></a>
			</li>
			<li>
				<a href="javascript:void(window.open(\'https://data.fineartstudioonline.com/follow/?admin_id=71836\',\'Get New Art Alerts\',\'status=1,toolbar=0,scrollbars=1,locationbar=0,menubar=0,resizable=1,width=640,height=480,left=256,top=192\').focus())" title="Get an automated email alert when Tonya Ramsey posts new art, Courtesy InformedCollector" target="_blank"><i class="fa fa-envelope"></i></a>
			</li>
		</ul>
		';
}