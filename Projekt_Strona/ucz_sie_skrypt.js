var contentArray = [];

var req = new XMLHttpRequest(); 
	req.onload = function() {
	contentArray = JSON.parse(this.responseText); 
	
	//console.log(contentArray);

	// for (const i in contentArray){
		// for (const x in contentArray[i]){
			// console.log(contentArray[i][x]);
		// }
	// }
	
	for (const i in contentArray){
		flashcardMaker(i);
	}

	
	
 };
req.open("get", "get_flashcards.php", true); 
req.send();





function flashcardMaker (i){
  const flashcard = document.createElement("div");
  const question = document.createElement('h2');
  const answer = document.createElement('h2');

  console.log(contentArray[i]);

  
  flashcard.className = 'flashcard';

  question.setAttribute("style", "border-top:1px solid red; padding: 15px; margin-top:30px");
  question.textContent = contentArray[i][0];

  answer.setAttribute("style", "text-align:center; display:none; color:red");
  answer.textContent = contentArray[i][1];

  flashcard.appendChild(question);
  flashcard.appendChild(answer);

  flashcard.addEventListener("click", () => {
    if(answer.style.display == "none")
      answer.style.display = "block";
    else
      answer.style.display = "none";
  })

  document.querySelector("#flashcards").appendChild(flashcard);
}


