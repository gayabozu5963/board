
function clickBtn1(reply_id){
	const p1 = document.getElementById(reply_id);

	if(p1.style.display=="block"){
		// noneで非表示
		p1.style.display ="none";
	}else{
		// blockで表示
		p1.style.display ="block";
	}
}


function clickBtn2(repliereplie_id){
	const p2 = document.getElementById(repliereplie_id);

	if(p2.style.display=="block"){
		// noneで非表示
		p2.style.display ="none";
	}else{
		// blockで表示
		p2.style.display ="block";
	}
}

//  var elements = document.getElementsByClassName("reply_a");

//  elements = Array.from( elements );

//  elements.forEach(x => x.style.display="none");



