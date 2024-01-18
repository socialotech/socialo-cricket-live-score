(function ($) {
    'use strict';

    /**
     * All of the code for your public-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     */
    $(function () {
        // Initialize the cricket live score functionality
        socialoCricketLiveScore_loadScoreData();

        // Set an interval to refresh data in defined interval
        const refreshInterval = Number(socialo_cricket_live_score_object.refresh_interval);

        // Set score refresh interval if interval is minimum 30 seconds
        if(refreshInterval && refreshInterval > 29){
            setInterval(function () {
                socialoCricketLiveScore_loadScoreData(false);
            }, (refreshInterval * 1000));
        }
    });

    /**
     * Fetch and display cricket live scores using AJAX in WordPress.
     *
     * @since 1.0.0
     */
    function socialoCricketLiveScore_loadScoreData(loader = true) {
        // Select necessary DOM elements
        let socialoCricketLiveScore_noMatchAvailable = $('.socialoCricketLiveScoreContainer .noMatchAvailable');
        let socialoCricketLiveScore_loadingUI = $('.socialoCricketLiveScoreContainer .loadingUI');
        let socialoCricketLiveScore_mainWrapper = $('.socialoCricketLiveScore');

        // Show loading UI, hide no match available message and main wrapper
        if(loader){
            socialoCricketLiveScore_loadingUI.show();
        }
        socialoCricketLiveScore_noMatchAvailable.hide();
        socialoCricketLiveScore_mainWrapper.hide();

        // Make AJAX request to fetch cricket live scores
        $.ajax({
            url: socialo_cricket_live_score_object.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'socialo_cricket_live_score_get_scores',
                _wpnonce: socialo_cricket_live_score_object.nonce
            },
            success: function (response) {
                // Handle successful AJAX response

                // Select the swiper wrapper element
                let swiperWrapper = $('.socialoCricketLiveScore .swiper-wrapper');

                let liveScoreData = response.data.data;

                if (liveScoreData.length > 0 && response.success) {
                    // Hide no match available message and show main wrapper
                    socialoCricketLiveScore_noMatchAvailable.hide();
                    socialoCricketLiveScore_mainWrapper.show();

                    // Reset the wrapper
                    swiperWrapper.html('');

                    // Get the max slides to show value
                    let max_slides = Number(socialo_cricket_live_score_object.max_slides);

                    // Iterate through each fixture in the response data
                    $.each(liveScoreData, function (index, fixture) {

                        // Break the loop if the maximum allowed slides are reached
                        if (index > max_slides) {
                            return false;
                        }

                        // Create a new liveScoreBox element
                        let liveScoreBox = $('<div>').addClass('swiper-slide flexCenter');

                        // Append HTML content to the liveScoreBox
                        liveScoreBox.html(`
                            <div class="swiper-slide flexCenter">
                                <div class="liveScoreBox">
                                    <p class="titleText">${fixture.league.name}: ${fixture.round}</p>
                                    <span class="dateText">${new Date(fixture.starting_at).toDateString()}</span>
                                    <div class="teamBox">
                                        <div class="homeTeamBox">
                                            <img src="${fixture.localteam.image_path}" alt="${fixture.localteam.name}" class="flag">
                                            <p class="teamName">${fixture.localteam.name}</p>
                                            <p class="score">${socialoCricketLiveScore_getScoreText(fixture.scoreboards, fixture.localteam.id)}</p>
                                        </div>
                                        <div class="vs">VS</div>
                                        <div class="awayTeamBox">
                                            <img src="${fixture.visitorteam.image_path}" alt="${fixture.visitorteam.name}" class="flag">
                                            <p class="teamName">${fixture.visitorteam.name}</p>
                                            <p class="score">${socialoCricketLiveScore_getScoreText(fixture.scoreboards, fixture.visitorteam.id)}</p>
                                        </div>
                                    </div>
                                    <hr class="divider">
                                    <p class="statusText">${socialoCricketLiveScore_getStatusText(fixture)}</p>
                                </div>
                            </div>
                        `);

                        // Append the liveScoreBox to the swiperWrapper
                        swiperWrapper.append(liveScoreBox);
                    });
                } else {
                    // Show no match available message and hide main wrapper
                    socialoCricketLiveScore_noMatchAvailable.show();
                    socialoCricketLiveScore_mainWrapper.hide();
                }

                // Initialize Swiper after appending all liveScoreBoxes
                const swiper = new Swiper('.swiper', {
                    direction: 'horizontal',
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                        bulletClass: 'paginationBullet',
                        bulletActiveClass: 'paginationActive'
                    }
                });
            },
            complete: function () {
                // Hide loading UI after AJAX request completes
                if(loader){
                    socialoCricketLiveScore_loadingUI.hide();
                }
            },
            error: function (error) {
                // Log and handle AJAX request error
                console.error('Error fetching data:', error);
            }
        });
    }

    /**
     * Get the formatted score text for a team.
     *
     * @param {Array} scoreboards - Array of scoreboards.
     * @param {number} teamId - ID of the team.
     * @returns {string} - Formatted score text.
     */
    function socialoCricketLiveScore_getScoreText(scoreboards, teamId) {
        const teamScoreboard = scoreboards.find(board => board.team_id === teamId && board.type === 'total');
        return teamScoreboard ? `${teamScoreboard.total}-${teamScoreboard.wickets} (${teamScoreboard.overs} overs)` : 'N/A';
    }

    /**
     * Get the formatted status text for a fixture.
     *
     * @param {Object} fixture - Fixture data.
     * @returns {string} - Formatted status text.
     */
    function socialoCricketLiveScore_getStatusText(fixture) {
        if (fixture.live) {
            return `${fixture.status} - ${fixture.note}`;
        } else {
            return `Scheduled for ${new Date(fixture.starting_at).toLocaleTimeString()}`;
        }
    }

})(jQuery);