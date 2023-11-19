export function millisecondsToStr (milliseconds) {
    // TIP: to find current time in milliseconds, use:
    // var  current_time_milliseconds = new Date().getTime();

    function numberEnding (number) {
        return (number > 1) ? 's' : '';
    }
    const result = [];
    var temp = Math.floor(milliseconds / 1000);
    var years = Math.floor(temp / 31536000);
    if (years) {
        result.push(years + ' year' + numberEnding(years));
    }
    var days = Math.floor((temp %= 31536000) / 86400);
    if (days) {
        result.push(days + ' day' + numberEnding(days));
    }
    var hours = Math.floor((temp %= 86400) / 3600);
    if (hours) {
        result.push(hours + ' hour' + numberEnding(hours));
    }
    var minutes = Math.floor((temp %= 3600) / 60);
    if (minutes) {
        result.push(minutes + ' minute' + numberEnding(minutes));
    }
    var seconds = temp % 60;
    if (seconds) {
        result.push(seconds + ' second' + numberEnding(seconds));
    }
    console.log(result);
    return result.join(" "); //'just now' //or other string you like;
}
