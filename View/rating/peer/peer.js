let completedRatings = parseInt(document.getElementById('completedCount').textContent)||0;
        const totalRatings =parseInt(document.getElementById('totalCount').textContent)||0;//pasrseInt converts a string(textcontent) to an integer eg: 003->3,50px->50(stops at first non-number)
        //JS is case sensitive so textcontent!=textContent,here textcontent throws an error
        const ratingTexts = {//show text when hovered or stars are clicked
            1: "Poor - Needs significant improvement",
            2: "Fair - Below expectations",
            3: "Good - Meets expectations",
            4: "Very Good - Exceeds expectations",
            5: "Excellent - Outstanding performance"
        };//basically the JS version of a PHP associative array with key,value pairs eg:ratingTexts[4] means(outputs) "Very Good - Exceeds expectations"

        // Initialize star rating functionality here . means select by class
        document.querySelectorAll('.starRating').forEach(starRating => {//select every star container in the page(one for every volunteer)
            const stars = starRating.querySelectorAll('.star');//selects all elements with class star INSIDE that specific(current loop's) .starRating div only aka "all stars inside this particular rating card"
            //runs the starRating => { ... } function for each starRating element returned from "document.querySelectorAll('.starRating')" + that arrow function is equivalent to "function(starRating) {}" where "starRating" is the current element in the loop
            //For every .starRating element on the page, run this block of code, with starRating representing that element
            const card = starRating.closest('.volunteerRatingCard');//find the nearest ancestor with class .volunteerRatingCard in the DOM tree
            const submitBtn = card.querySelector('.submitRating');//card's submit button
            const ratingText = starRating.nextElementSibling;//gets div class="ratingText"
            
            stars.forEach((star, index) => {//loops over all stars in one card here star=the current star element and index=position of that star
                star.addEventListener('click', () => {
                    const rating = index + 1;//converts 0 based index to 1-5 scale
                    starRating.dataset.rating = rating;//saves this rating in the card’s data attribute
                    
                    // Update star display = visually mark which stars are active by looping over all stars again 
                    stars.forEach((s, i) => {
                        s.classList.toggle('active', i < rating);//handles last star as 4<5 and makes them highlighted
                    });
                    
                    // Update rating text
                    ratingText.textContent = ratingTexts[rating];//update based on "rating"'s value
                    
                    // Enable submit button
                    submitBtn.disabled = false;
                });

                star.addEventListener('mouseenter', () => {
                    const rating = index + 1;//need to compare with index below
                    stars.forEach((s, i) => {//forEach((element, index)=>{}); the element and index are repectively like this i.e. in forEach, the first parameter is always the element, the second is always the index, and the third (optional) is the array itself
                        s.style.color = i < rating ? '#f39c12' : '#bdc3c7';
                    });
                    ratingText.textContent = ratingTexts[rating];//show rating text corresponding to hovered star
                });
            });

            starRating.addEventListener('mouseleave', () => {//when mouse leaves star area reset the star colors to match the current selected rating
                const currentRating = parseInt(starRating.dataset.rating);//gets the rating the user clicked before (stored in the data-rating attribute)
                stars.forEach((s, i) => {//loop over all stars
                    s.style.color = i < currentRating ? '#f39c12' : '#bdc3c7';//color it if index is less than current rating(fill the star)
                });
                ratingText.textContent = currentRating > 0 ? ratingTexts[currentRating] : '';//update the text
            });
        });



//// Handle rating submission(rating and comment) (here . means select by class) + multiple submit buttons of differnt cards
document.querySelectorAll('.submitRating').forEach(btn => {//btn is the current element in the loop
    btn.addEventListener('click', function() {
        const card = this.closest('.volunteerRatingCard');//closest DOM ancestor=finds the card containing this button
        const starRating = card.querySelector('.starRating');//get div with all stars
        const rating = parseInt(starRating.dataset.rating);
        const comment = card.querySelector('.commentInput').value;
        const volunteerId = card.dataset.volunteer;//gets ratee_id
        //attribute starting with data-xxx is called a data attribute , In JavaScript you access it with element.dataset.xxx 
        const assignmentId = card.dataset.assignment;//dataset automatically maps all data-xxx attributes to camelCase keys in JS eg:data-user-id="5" -> el.dataset.userId

        if (rating > 0) {
            // Disable button immediately to prevent double-submission
            this.disabled = true;
            this.textContent = 'Submitting...';
            
            // Submit rating via AJAX + update UI without reloading the page + FormData is a built-in JS object that mimics a form submission
            const formData = new FormData();//AJAX submit using formdata object to do this without reloading the page
            formData.append('assignment_id', assignmentId);//“Append” here literally means stick it to the end of the FormData collection, ready to be sent in the POST request
            formData.append('ratee_id', volunteerId);//If the key already exists, it adds another value for the same key (FormData can hold multiple values per key)
            formData.append('rating', rating);//formData.append(key, value) adds a new key-value pair to the FormData object
            formData.append('comment', comment);//append key-value pairs (like assignment ID, volunteer ID, rating, comment) this way we can send data without a form tag thruh AJAX

            fetch('/V/router.php?module=rating&action=submitpeerrating', {//send an HTTP request to the server
                method: 'POST',//indicates this is a POST request
                body: formData//the data being sent
            })
            //handle server responses
            .then(response => response.json())
            .then(data => {
                if (data.success) {// Mark as completed
                    //data.success checks if the server confirmed the rating was successfully saved
                    card.classList.add('completed');//visually mark the card
                    this.textContent = 'Rating Submitted';//update button text
                    
                    // Disable all controls in this card
                    starRating.style.pointerEvents = 'none';//prevent clicking stars
                    card.querySelector('.commentInput').disabled = true;//disable comment input
                    
                    // Update progress
                    completedRatings++;//increase completed counter
                    updateProgress();//refresh progress bar and counts
                    
                    // Show completion section if all ratings done
                    if (completedRatings === totalRatings) {//all ratings are done
                        setTimeout(() => {
                            document.getElementById('completionSection').classList.add('show');//show completion section
                            document.querySelector('.ratingSection').style.display = 'none';//hide rating section
                        }, 1000);//1000 mili seconds= runs code after a 1 second delay
                    }
                } else {
                    // Error - revert UI =if server returned failiure -> show alert + restore the button
                    alert('Error: ' + (data.message || 'Failed to submit rating'));
                    this.disabled = false;//re-enable the button
                    this.textContent = 'Submit Rating';//revert text (this refers to the submit button that was clicked)
                }
            })
            //network error catch
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to submit rating. Please try again.');
                this.disabled = false;
                this.textContent = 'Submit Rating';//Log the error to console for debugging and reset the UI.
            });
        }
    });
}); 


         

        function updateProgress() {//keeps the progress section in sync with the ratings you submit
            const progressPercent = totalRatings>0? Math.round((completedRatings / totalRatings) * 100):0;
            const remaining = totalRatings - completedRatings;//normal calculations to find how many ratings are completed(%) and how many are left
            //update UI without reloading
            document.getElementById('completedCount').textContent = completedRatings;
            document.getElementById('progressPercent').textContent = progressPercent + '%';
            document.getElementById('progressFill').style.width = progressPercent + '%'; // handle illusion of completion via width of bar + adjusts the width of the progress bar visually
            document.getElementById('remainingCount').textContent = remaining + ' remaining';
        }

        // Initialize progress + Calls the function once at the start to set the initial progress when the page loads
        updateProgress();

        // // Handle view results button
        // document.querySelector('.viewResultsBtn').addEventListener('click', () => {
        //     alert('Redirecting to your rating results page...');
        //     // In the application, this would navigate to the results page
        // });