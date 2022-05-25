// entry.cjs
// https://stackoverflow.com/questions/71408615/how-to-launch-a-sveltekit-app-on-plesk-phusion-passenger
async function loadApp() {
    const { app } = await import("./main.js");
}
loadApp()