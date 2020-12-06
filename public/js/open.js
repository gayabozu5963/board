
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



//  var elements = document.getElementsByClassName("reply_a");

//  elements = Array.from( elements );

//  elements.forEach(x => x.style.display="none");



// // モーダルが開いた時の処理
// $('#modalForm').on('show.bs.modal', function (event) {
//     //モーダルを開いたボタンを取得
//     var button = $(event.relatedTarget);
//     //モーダル自身を取得
//     var modal = $(this);
//     //data-cusnoの値取得
//     var cusnoVal = button.data('cusno');
//     // input 欄に値セット
//     modal.find('.modal-body input#cusno').val(cusnoVal);
//     //data-visitdayの値取得
//     var visitdayVal = button.data('visitday');
//     modal.find('.modal-body input#oldday').val(visitdayVal);
// });

