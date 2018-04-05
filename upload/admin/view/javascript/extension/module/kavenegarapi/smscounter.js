function addSMSCounter(textarea) {
    if (typeof (textarea) == 'string') {
        textarea = document.getElementById(textarea);
    }
    var counterDiv = document.createElement('div');

    var span = document.createElement('span');
    span.innerHTML = 'تعداد کاراکتر باقيمانده : ';
    span.style.fontSize = "11px";
    span.style.color = "#666666";
    counterDiv.appendChild(span);

    var counterSpan = document.createElement('span');
    counterSpan.innerHTML = '160(1)';
    counterDiv.appendChild(counterSpan);

    var dv = document.createElement('span');
    dv.innerHTML = '&nbsp; &nbsp; &nbsp; زبان : ';
    dv.style.color = "#666666";
    counterDiv.appendChild(dv);

    var langSpan = document.createElement('span');
    langSpan.innerHTML = 'زبان';
    langSpan.style.fontSize = "11px";
    counterDiv.appendChild(langSpan);

    textarea.style.direction = 'ltr';

    if (textarea.nextSibling) {
        textarea.parentNode.insertBefore(counterDiv, textarea.nextSibling);
    } else textarea.parentNode.appendChild(counterDiv);

    textarea.onkeypress = textarea.onkeyup = textarea.checkSMSLength = function() {
        checkSMSLength(textarea, counterSpan, langSpan);
    }

    checkSMSLength(textarea, counterSpan, langSpan);
}

function checkSMSLength(textarea, counterSpan, langSpan) {
    var text = textarea.value;
    var ucs2 = text.search(/[^\x00-\x7E]/) != -1
    if (!ucs2) text = text.replace(/([[\]{}~^|\\])/g, "\\$1");
    var unitLength = ucs2 ? 70 : 160;

    langSpan.innerHTML = ucs2 ? 'فارسی' : 'انگلیسی';
    textarea.style.direction = text.match(/^[^a-z]*[^\x00-\x7E]/ig) ? 'rtl' : 'ltr';

    if (text.length > unitLength) {
        if (ucs2) unitLength = unitLength - 3;
        else unitLength = unitLength - 7;
    }

    var count = Math.max(Math.ceil(text.length / unitLength), 1);
    counterSpan.innerHTML = (unitLength * count - text.length) + '(' + count + ')';
		
	/*Normalizing char*/
    var arabicChars = ["ي", "ك", "‍", "دِ", "بِ", "زِ", "ذِ", "ِشِ", "ِسِ", "‌", "ى"],
				persianChars = ["ی", "ک", "", "د", "ب", "ز", "ذ", "ش", "س", "", "ی"];

    for (var i = 0, charsLen = arabicChars.length; i < charsLen; i++) {
     text = text.replace(new RegExp(arabicChars[i], "g"), persianChars[i]);
    }
    textarea.value=text;

}
