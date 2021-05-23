
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
