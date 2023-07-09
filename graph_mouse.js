function barOnMouseOver(bar){
	var bar_data = document.getElementById(bar.getAttribute('bar_data_id'));
	bar.setAttribute('mouseover', 'true');
	bar_data.setAttribute('active', 'true');
	bar_data.innerHTML = 'y: '+bar.getAttribute('y_data')+' x: '+bar.getAttribute('x_data')+'';
}

function barOnMouseLeave(bar){
	var bar_data = document.getElementById(bar.getAttribute('bar_data_id'));
	bar.setAttribute('mouseover', 'false');
	bar_data.setAttribute('active', 'false');
	bar_data.innerHTML = '';
}