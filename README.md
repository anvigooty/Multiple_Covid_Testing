# Multiple_Covid_Testing
This project demonstrates the problem that exists regarding multiple COVID tests being performed within a 24 hour interval for a single patient and suggest changes in OpenEMR which can aid combat this issue. The list of codes in this file represents :
- All the modfication we need to make in OpenEMR for a COVID testing form to be generated.
- Code in phpmyadmin/OpenEMR for the views to work which is required to generate tables for our alerts.
- Rmarkdown code to show the evidence of the problem which exists in the population.
## Codes
| Code | Description |
|------|-------------|
|01_table.sql | Create a table if it doesn't already exist|
|02_info.txt | Name of the form |
|03_new.php | For the form |
|04_print.php | For the form |
|05_report.php | For the form |
|06_save.php | For the form |
|07_view.php | For the form |
|08_v_covid_procedures.sql | allows for new tools to “see” tests ordered either way |
|09_v_covid.sql | adds fields needed to alert the table created ny new covid form |
|10_v_procedures.sql | to set up alerts within the old workflow |
|11_project-sql.txt | Overview of all the codes |
|Synthea_Multiple_Covid_Testing.Rmd | Shows evidence of the existing condition in the population |
## Notes
One caveat to keep in mind is that all these codes here will let you create a form in OpenEMR , but the actual sql for the forms to show up is not included here as it contains PHI( dates), but rest of the code is available.
