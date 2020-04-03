<?php

namespace template;

function nav_links($mobile=false){
echo '<ul ';
if($mobile) echo ' class="sf-menu sf-js-enabled" style="touch-action: pan-y;"> ';
else echo ' style="display: none;">';
echo '
	<li class="navlink">
		<a href="https://www.tonyaramseyart.com">Home</a>
	</li>
	<li class="navlink">
		<a href="https://www.tonyaramseyart.com/about">About</a>
	</li>
	<li class="selectednavlink">
		<a href="https://www.tonyaramseyart.com/works">Works</a>
	</li>
	<li class="navlink">
		<a href="https://www.tonyaramseyart.com/contact">Contact</a>
	</li>
	<li class="navlink">
		<a href="https://www.tonyaramseyart.com/email-newsletter">Newsletter</a>
	</li>
	<li class="navlink">
		<a href="https://www.tonyaramseyart.com/galleries">Galleries</a>
	</li>
	<li class="navlink">
		<a href="https://www.tonyaramseyart.com/events">Events</a>
	</li>
	<li class="emptynavlink">
	<a href="https://www.tonyaramseyart.com/?keyvalue=71836&amp;page="></a>
	</li>
	<li class="emptynavlink">
	<a href="https://www.tonyaramseyart.com/?keyvalue=71836&amp;page="></a>
	</li>
	<li class="emptynavlink">
	<a href="https://www.tonyaramseyart.com/?keyvalue=71836&amp;page="></a>
	</li>
	<li class="emptynavlink">
	<a href="https://www.tonyaramseyart.com/?keyvalue=71836&amp;page="></a>
	</li>
	<li class="emptynavlink">
	<a href="https://www.tonyaramseyart.com/?keyvalue=71836&amp;page="></a>
	</li>
	<li class="emptynavlink">
	<a href="https://www.tonyaramseyart.com/?keyvalue=71836&amp;page="></a>
	</li>
</ul>
	';
}
