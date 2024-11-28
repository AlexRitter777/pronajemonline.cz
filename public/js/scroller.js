/**
 * Scroll page to errors div message
 */
document.addEventListener('DOMContentLoaded', function () {
    let messageDivs = document.getElementsByClassName('scroll-message');
    if(messageDivs.length > 0) {
        seamless.scrollIntoView(messageDivs[0],
            { behavior: "smooth",
                block: "center",
                inline: "center" }
        );
        setTimeout(() => {
            window.scrollBy(0, 100); // Adjust `+100` for more offset
        }, 500);
    }
    // Adjust scroll after a slight delay to show more of the div
    // Delay, to ensure scrollIntoView finishes
});