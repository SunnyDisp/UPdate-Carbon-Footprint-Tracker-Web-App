# CMSC-207-Final-Project

### Project Title
UPdate Carbon Footprint Tracker

### Project Overview
The UPdate web application, developed for the University of the Philippines Open
University, is a user-friendly tool designed to help individuals measure and reduce their carbon footprint. It is built using core web technologies—HTML for structure, CSS for styling, JavaScript for interactivity, PHP for server-side processing, and MySQL for database management—without the use of external frameworks.

By allowing real-time data input, the system enables users to log their daily activities and calculate the corresponding carbon emissions. The application then provides immediate
feedback, indicating whether the user’s daily carbon footprint falls within the ideal threshold. If the footprint exceeds the recommended limit, the system offers practical suggestions for reducing emissions and promoting more eco-friendly habits.

Although UPdate is still in its early stages of development, plans are underway to
enhance its features. Future updates aim to include more activity metrics, graphical
representations of usage trends, and category-specific suggestions tailored to each user’s carbon output. These improvements will support more accurate tracking and promote deeper engagement with sustainability goals.

### Features
* User Authentication: Allows users to sign up and log in to their personalized dashboards using their credentials.
* Personalized Dashboard: Users can log and track their daily activities to determine whether they stay within the ideal 13.7 kg/day carbon limit.
* Emission Insight: For users who may be unfamiliar with the concept of carbon footprints, the Information Page provides a brief overview and highlights the importance of being mindful of one's emissions.
* User-friendly Navigation: The navigation bar contains clearly-labeled links that allows users to seamlessly access key sections of the site.
* Sustainability Impact: Created to emplower individuals to monitor their daily carbon emissions and build more sustainable habits.

### Technologies Used
* HTML: Defines the structure of the web pages
* CSS: Handles styling and layout adjustments
* JavaScript: Adds interactivity and enables dynamic content updates
* PHP: Server-side scripting used to connect the front end to the database
* MySQL: Stores user-inputted data and predefined carbon emissions for each activity
  
### Webpage Structure
The website consts of seven sections, each build using PHP for to connect front-end with back-end:
* Sign In Page
* Sign Up Page
* Home Page (Activity Tracker)
* Information Page
* Navigation Bar
* Footer

The Login Page allows users to log in to their personalized dashboards using their
credentials. For new users, a link to the Registration Page is conveniently located below the “Sign In” button.

On the Registration Page, users can create an account by choosing a unique username
and password. The system enforces distinct username selection to prevent duplication and
ensure that user data remains secure and unique.

After signing in, users are redirected to the Home Page, where they can log their daily
activities. Users select a category, choose a specific activity, and input the number of units based on their chosen activity. The system automatically populates the estimated emissions and activity description.

By clicking the “Calculate your daily emission” button, the input is stored in the
activity_logs table, and the system calculates the total emissions for the day and the average daily emission. If the daily total exceeds the ideal daily carbon emission of 13.7 kilograms, the app displays eco-friendly recommendations to help reduce carbon output.

The Information Page is designed for users who may be unfamiliar with the concept of
carbon footprints. It provides a brief, informative overview of what a carbon footprint is and highlights the importance of being mindful of one’s daily emissions. Additionally, an embedded YouTube video offers supplementary educational content for a better understanding.

Lastly, the header of the UPdate Carbon Footprint Tracker features a clean and intuitive
navigation bar that allows users to seamlessly access key sections of the site. It includes direct links to view logged activities, access information about carbon footprints, and securely sign out using a logout form. The footer serves as a dedicated acknowledgment section, expressing gratitude to the individual who significantly supported the development of the project.
