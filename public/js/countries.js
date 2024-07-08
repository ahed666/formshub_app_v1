


// countries.js
export async function getCountries() {
    const response = await fetch('./countries.json'); // Ensure the correct path
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    const data = await response.json();
    return data;
}
