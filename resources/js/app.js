import './bootstrap';

import Alpine from 'alpinejs';

import $ from 'jquery';

window.Alpine = Alpine;

Alpine.start();

$(document).ready(function() {
    // Add Job
    $("input[name = 'musician-number']").on('click', function(e) {
        let numberOfRequestedJobs = e.currentTarget.value;
        let numberOfCurrentJobs = ($('#jobs-list .more-job-template').length);

        if (numberOfRequestedJobs == numberOfCurrentJobs) {
            return;
        } else if (numberOfRequestedJobs < numberOfCurrentJobs) {
            let numberOfChildrenToRemove = numberOfCurrentJobs - numberOfRequestedJobs;
            removeNewJobs(numberOfChildrenToRemove);
        } else if (numberOfRequestedJobs > numberOfCurrentJobs) {
            var payment = '';
            if ($('input[name = "payment-method"]:checked').val() == 'same') {
                payment = $("#payment-all").val();
            }
            addNewJobs(numberOfCurrentJobs, numberOfRequestedJobs, payment);
        }

    });
    function addNewJobs(index, numberOfRequestedJobs, payment) {
        $.ajax({
            url: `${window.location.origin}/new-job-component?number=${index + 1}&payment=${payment}`,
            type: 'GET',
            complete: function() {
                index++;
                if (index < numberOfRequestedJobs) {
                    addNewJobs(index, numberOfRequestedJobs, payment);
                }
            },
            success: function(result) {
                $('#jobs-list').append(result);
            }
        });
    }
    function removeNewJobs(numberOfChildrenToRemove) {
        let index = 0;
        do {
            $('#jobs-list').children('.more-job-template').last().remove();
            index++;
        } while(index < numberOfChildrenToRemove);
    }

    // Clear Form
    $('#clear-create-gig-form').on('click', function(){
        if (confirm('Are you sure you want to clear this Gig and all musicians') == true) {
            $('#select1').select2("val", "");
            $('form :input').val('');
            $('form :select').val('');
            $('#jobs-list').children('.more-job-template:not(:first-child)').remove();
            $('#create-gig-form')[0].reset();
        };
    })

    // Delete Gig
    $('#delete-gig-button').on('click', function() {
        // show a confirmation dialog using jQuery UI
        if (confirm('Are you sure you want to delete this gig?')) {
            // if the user confirms, submit the delete form
            $('#delete-gig-form').submit();
        }
    });

    //Payment Dom Events
    //1.Toggle visibility payment
    $("input[name = 'payment-method']").on('click', function(e) {
        if (e.target.value == "mixed"){
            return $('#payment-all').parent().css('visibility', 'hidden');
        }
        return $('#payment-all').parent().css('visibility', 'visible');

    });

    //2. Add payment to all musicians
    var typingTimer;
    var doneTypingInterval = 500;
    $("#payment-all").on('input', function(){
        if ($('input[name = "payment-method"]:checked').val() == 'same') {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(fillPayoutInfo, doneTypingInterval);
        }
    });

    function fillPayoutInfo() {
        $(".more-job-template").each(function(){
            $(this).find('#payment-for-job').val($("#payment-all").val());
       })
    }
    //3.????

    //
});