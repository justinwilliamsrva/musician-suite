import './bootstrap';

import Alpine from 'alpinejs';

import $ from 'jquery';

window.Alpine = Alpine;

Alpine.start();

$(document).ready(function() {
    // Add Job
    $("input[name = 'musician-number']").click(function(e) {
        let numberOfRequestedJobs = e.currentTarget.value;
        let numberOfCurrentJobs = ($('#jobs-list .more-job-template').length);

        if (numberOfRequestedJobs == numberOfCurrentJobs) {
            return;
        } else if (numberOfRequestedJobs < numberOfCurrentJobs) {
            let numberOfChildrenToRemove = numberOfCurrentJobs - numberOfRequestedJobs;
            removeNewJobs(numberOfChildrenToRemove);
        } else if (numberOfRequestedJobs > numberOfCurrentJobs) {
            addNewJobs(numberOfCurrentJobs, numberOfRequestedJobs);
        }

    });
    function addNewJobs(index, numberOfRequestedJobs) {
        $.ajax({
            url: `${window.location.origin}/new-job-component?number=${index + 1}`,
            type: 'GET',
            complete: function() {
                index++;
                if (index < numberOfRequestedJobs) {
                    addNewJobs(index, numberOfRequestedJobs);
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
    $('#clear-create-gig-form').click(function(){
        if (confirm('Are you sure you want to clear this Gig and all musicians') == true) {
            $('#jobs-list').children('.more-job-template:not(:first-child)').remove();
            $('#create-gig-form')[0].reset();
        };
    })
});