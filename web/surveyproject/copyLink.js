function copyLink(code) {
    prompt("Share this link to your survey:", `${String(window.location).slice(0, String(window.location).lastIndexOf('/'))}/survey.php?s=${code}`);
    return false;
}