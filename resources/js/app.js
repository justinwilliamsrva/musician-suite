import './bootstrap';

import Alpine from 'alpinejs';

import $ from 'jquery';

import.meta.glob([ '../assets/**', ]);

window.Alpine = Alpine;

Alpine.start();

$(document).ready(function() {
    // Add new Job, add highlighting to musician-number inputs and pass in payment information
    $("input[name = 'musician-number']").on('click', function(e) {
        let numberOfRequestedJobs = e.currentTarget.value;
        let numberOfCurrentJobs = ($('#jobs-list .more-job-template').length);

        if (numberOfRequestedJobs == numberOfCurrentJobs) {
            return;
        }
        changeMusicianNumberBorderColor(numberOfRequestedJobs);

        if (numberOfRequestedJobs < numberOfCurrentJobs) {
            let numberOfChildrenToRemove = numberOfCurrentJobs - numberOfRequestedJobs;
            removeNewJobs(numberOfChildrenToRemove);
        } else if (numberOfRequestedJobs > numberOfCurrentJobs) {
            var payment = '';
            var url = '';

            if ($('input[name = "payment-method"]:checked').val() == 'same') {
                payment = $("#payment-all").val();
            }

            if (window.location.pathname.includes('edit')) {
                url = `${window.location.origin}/edit-job-component?number=`;
            } else {
                url = `${window.location.origin}/new-job-component?number=`;
            }

            addNewJobs(numberOfCurrentJobs, numberOfRequestedJobs, payment, url);
        }

    });
    function addNewJobs(index, numberOfRequestedJobs, payment, url) {
        $.ajax({
            url: `${url}${index + 1}&payment=${payment}`,
            type: 'GET',
            complete: function() {
                index++;
                if (index < numberOfRequestedJobs) {
                    addNewJobs(index, numberOfRequestedJobs, payment, url);
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
    function changeMusicianNumberBorderColor($number) {
        $(".musician-number-button").each(function(){
            if ($(this).find('input').val() == $number) {
                $(this).addClass('border-indigo-700').removeClass('border-gray-300');
            } else {
                $(this).removeClass('border-indigo-700').addClass('border-gray-300');
            }
        });
    }

    // Clear Form
    $('#clear-create-gig-form').on('click', function(){
        if (confirm('Are you sure you want to clear this gig and all musicians') == true) {
            $('#jobs-list').children('.more-job-template:not(:first-child)').remove();
            $('#create-gig-form')[0].reset();
            $('.select2-selection__rendered').children().remove();
            changeMusicianNumberBorderColor(1);
        };
    })

    // Delete Gig
    $('#delete-gig-button').on('click', function() {
        if (confirm('Are you sure you want to delete this gig?')) {
            $('#delete-gig-form').submit();
        }
    });

    // Update Gig
    $('#update-gig-button').on('click', function() {
        $('#update-gig-form').submit();
    });

    //Remove Application
    $('#remove-application-button').on('click', function() {
        if (confirm('Are you sure you want to remove your application for this gig?')) {
            $('#remove-application-form').submit();
        }
    });

    //Payment Dom Events
    //1.Toggle visibility payment
    $("input[name = 'payment-method']").on('click', function(e) {
        if (e.target.value == "mixed"){
            return $('#payment-all').parent().css('visibility', 'hidden');
        }

        if ($('payment-all').val() != '') {
            fillPayoutInfo();
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

    //Edit Blade
    if ($('input[name = "payment-method"]:checked').val() == 'mixed') {
        $('#payment-all').parent().css('visibility', 'hidden');
    }

    // Music Finder Filter Submissions
    $('#instrument_match_span').on('click', function(){
        $("#openGigsFilter").submit();
    });

    $('#user_jobs_show_all_span').on('click', function(){
        $("#userJobsFilter").submit();
    });

    $('#user_gigs_show_all_span').on('click', function(){
        $("#userGigsFilter").submit();
    });
});