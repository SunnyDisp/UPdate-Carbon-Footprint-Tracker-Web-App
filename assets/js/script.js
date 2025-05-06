document.addEventListener('DOMContentLoaded', () => {
    const categorySelect = document.getElementById('activity-category');
    const activitySelect = document.getElementById('activity-specific');
    const unitInput = document.getElementById('activity-unit');
    const emissionInput = document.getElementById('activity-emission');
    const notesInput = document.getElementById('activity-notes');
    const unitLabel = document.getElementById('unit-label');

    function getSelectedActivity() {
        const selectedCatId = categorySelect.value;
        const selectedActivityId = activitySelect.value;
        const activities = activitiesByCategory[selectedCatId] || [];
        return activities.find(a => a.id == selectedActivityId);
    }

    function populateActivities() {
        const selectedCatId = categorySelect.value;
        const activities = activitiesByCategory[selectedCatId] || [];

        // Clear previous options
        activitySelect.innerHTML = '';

        // Populate new options
        for (const activity of activities) {
            const option = document.createElement('option');
            option.value = activity.id;
            option.textContent = activity.activity;
            activitySelect.appendChild(option);
        }

        // Trigger detail update if there are activities
        if (activities.length > 0) {
            activitySelect.selectedIndex = 0;
            updateDetails();
        } else {
            unitLabel.textContent = 'Unit';
            notesInput.value = '';
            emissionInput.value = '';
        }
    }

    function updateDetails() {
        const activity = getSelectedActivity();

        if (!activity) {
            unitLabel.textContent = 'Unit';
            notesInput.value = '';
            emissionInput.value = '';
            return;
        }

        // Update label and description
        unitLabel.textContent = activity.unit || 'Unit';
        notesInput.value = activity.remarks || '';

        // Calculate emission
        const quantity = parseFloat(unitInput.value) || 0;
        const emission = quantity * parseFloat(activity.emission_per_unit || 0);
        emissionInput.value = emission.toFixed(3);
    }

    // Event Listeners
    categorySelect.addEventListener('change', populateActivities);
    activitySelect.addEventListener('change', updateDetails);
    unitInput.addEventListener('input', updateDetails);

    // Initial population
    populateActivities();
});
