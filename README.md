<h1 align="center"style="border-bottom:none;margin:0">
  <a name="logo" href="https://github.com/justinwilliamsrva/musician-suite-cr#logo">
      <img src="resources/assets/images/MS.png" alt="Musician Suite" width="192">
  </a>
  <br>
  <br>
  Musician Suite - CR
</h1>



<div align="center"><a name="menu"></a>
  <h4>
    <a href="https://github.com/justinwilliamsrva/musician-suite-cr#Overview">
      Overview
    </a>
    <span> | </span>
    <a href="https://github.com/justinwilliamsrva/musician-suite-cr#Contributions">
      Contribution Guidelines
    </a>
    <span> | </span>
    <a href="https://github.com/justinwilliamsrva/musician-suite-cr#MusciansFinder">
      App 1 - Musican Finder
    </a>
  </h4>
</div>

---

<br>

<h1 align="center" style="text-align: center;border-bottom:none" name="Overview">Overview<a href="https://github.com/justinwilliamsrva/musician-suite-cr#logo"><img align="right" border="0" src="https://raw.githubusercontent.com/CCOSTAN/Home-AssistantConfig/master/config/www/custom_ui/floorplan/images/branding/up_arrow.png" width="22"></a></h1>

<h3>Client</h3>

<P>
Classical Revolution RVA's General Director and CRRVA's musician community.
</p>

<h3>About</h3>

<P>
The Musician Suite is a collection of web services built to benefit CRRVA's community of musicians. Any features or services not approved by the CRRVA will be used in other projects.
</p>

<h3>List of Services</h3>

<p>
- Musician Finder: An app that allows CRRVA musicians to find new gigs and hire musicians.
- MORE TO COME!
</p>

<br>

<h1 align="center" style="text-align: center;border-bottom:none" name="Contributions">Contribution Guidelines <a href="https://github.com/justinwilliamsrva/musician-suite-cr#logo"><img align="right" border="0" src="https://raw.githubusercontent.com/CCOSTAN/Home-AssistantConfig/master/config/www/custom_ui/floorplan/images/branding/up_arrow.png" width="22"></a></h1>

<h3>Steps to Add Contributions to the Repo</h3>


1. Add your idea for a feature or mention any problems you see as an issue or email the owner at justinwdev@gmail.com.
2. Pull down the development branch and create a new branch based off it with your feature name
3. Push up code to that branch using commits that tell what the commit does and end in a period.
    a. Add new hover animation to buttons.
    b. State abbreviations now use config instead of database.
4. Once you are finished with the feature, create a Pull Request. Here some PR basics
    a. The base branch should be development and the compare branch should your new feature branch
    b. Review your changes for correct formatting, indentation and spacing.
    c. Review your changes to be sure all your new code is present and no accidental changes were made. 
5. From there either the owner will add comments to the pull request or it will be approved and merged into development for testing.

<br>

<h1 align="center" style="text-align: center;border-bottom:none" name="MusciansFinder">Musician Finder<a href="https://github.com/justinwilliamsrva/musician-suite-cr#logo"><img align="right" border="0" src="https://raw.githubusercontent.com/CCOSTAN/Home-AssistantConfig/master/config/www/custom_ui/floorplan/images/branding/up_arrow.png" width="22"></a></h1>

<h3> User Story</h3>


AS A Professional Musician
I WANT to input details for an upcoming gig, email the job to interested musicians and select a musician to fill the position
SO THAT I can quickly find quality musicians for an event and see new gigs available for my instrument in Central Virginia
<br>

<h3> Features</h3>


DESIGN
- Dashboard and Booking page should look similar to Classical RVA Website
- App will use a subdomain of www.classicalrevolutionrva.com

BOOKING
- Users can create a gig with basic information(Location, Date, Music etc.)
- Users can enter in instruments needed for the gigs and amount to be payed
- Once submitted, the gig is sent to users who play the instruments needed and will also be added to the Dashboard

EMAILS
- Users will be able to click a button in the email to accept a gig. 
- Users who created the gig will receive updates if anyone has agreed to their gig
- All users involved will be notified if a musician has been selected

USER SETTINGS
- Users can create their account, delete their account, and change their password
- Users can add what instruments they play
- Users can set payment limits(optional)

DASHBOARD
 - Users can see all available gigs, current gigs they have been approved for and gigs where they have hired someone else
 - Users can select a musician for their gigs

JOBS
- If a job has not been filled 2 days before a gig, an email will be sent out to the gig maker to see if it was filled
- If you have accepted a gig, an email will be sent to the day before the gig at 9am EST as a reminder

TECH STACK 
- PHP
- JQuery
- AlpineJS
- Tailwind CSS
- Laravel

