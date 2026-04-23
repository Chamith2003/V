async function leaveEvent(eventId) {
    //Leave an Event using AJAX
    try {
        const formData = new FormData();
        formData.append('eventId', eventId);//key-value
         const response = await fetch('/V/router.php?module=calendar&action=leaveevent', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();//get response from other end and store it in data
//returns success,message,pointslost[star,level]
        
        if (data.success) {            
            //the warning is there due to high leave frequency
            let message = `<p>${data.message}</p>`;

            if (data.warning) {
                message += `<p>${data.warning}</p>`;}
            if (data.warningdetails) {
                message +=`<p>${data.warningdetails}</p>`;}
                     
                    showmessage(message);

            if(typeof updateCalendar==='function'){
                    updateCalendar();//on calendar page- refresh grid
            }
            //on event page- reload after user closes modal trigger only after user closes modal     
        
        }
        else {
            showmessage(data.message);
        }
    } catch (error) {
        console.error('Error leaving event:', error);
        showmessage('Failed to leave event');
    }
}


