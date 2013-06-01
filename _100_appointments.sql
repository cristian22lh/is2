/**
*
* PARA QUE ESTE SCRIPT FUNCIONES LOS MEDICOS DEBE ATENDER TODOS LOS DIAS
* DEBE HABER 7 PACIENTES QUE SOPORTEN LA OBRA SOCIAL ID = 1 (LIBRE)
*
*/
SET NAMES 'utf8';
USE is2;
/**
*
*/
TRUNCATE TABLE turnos;
/**
*
*/
DROP FUNCTION IF EXISTS getDayNameIndex;
DELIMITER $$
CREATE FUNCTION getDayNameIndex( offset INTEGER )
RETURNS INTEGER
BEGIN
	DECLARE today INTEGER;
	SELECT DAYOFWEEK( ADDDATE( CURRENT_DATE(), INTERVAL offset DAY ) ) INTO today;
	SELECT IF( today = 1, 7, today - 1 ) INTO today;
	RETURN today;
END$$
DELIMITER ;
/**
*/
DROP FUNCTION IF EXISTS getPatientWithNonInsurance;
DELIMITER $$
CREATE FUNCTION getPatientWithNonInsurance( avoidThisPatientID INTEGER )
RETURNS INTEGER
BEGIN
	DECLARE idPatient INTEGER;
	SELECT id FROM pacientes WHERE idObraSocial = 1 AND id > avoidThisPatientID LIMIT 1 INTO idPatient;
	RETURN idPatient;
END $$
DELIMITER ;
/**
*/
DROP FUNCTION IF EXISTS getDoctorIDBasedOnADayNameIndex;
DELIMITER $$
CREATE FUNCTION getDoctorIDBasedOnADayNameIndex( dayNameIndex INTEGER )
RETURNS INTEGER
BEGIN
	DECLARE doctorID INTEGER;
	SELECT m.id FROM medicos AS m INNER JOIN horarios AS h ON h.idMedico = m.id WHERE h.dia = dayNameIndex LIMIT 1 INTO doctorID;
	RETURN doctorID;
END $$
DELIMITER ;
/**
*/
DROP FUNCTION IF EXISTS getDoctorEntryTimeWithID;
DELIMITER $$
CREATE FUNCTION getDoctorEntryTimeWithID( doctorID INTEGER )
RETURNS TIME
BEGIN
	DECLARE entryTime TIME;
	SELECT h.horaIngreso FROM medicos AS m INNER JOIN horarios AS h ON h.idMedico = m.id WHERE m.id = doctorID LIMIT 1 INTO entryTime;
	RETURN entryTime;
END $$
DELIMITER ;
/**
*/
DROP FUNCTION IF EXISTS getAppointmentDate;
DELIMITER $$
CREATE FUNCTION getAppointmentDate( offset INTEGER )
RETURNS DATE
BEGIN
	DECLARE appointmentDate DATE;
	SELECT ADDDATE( CURRENT_DATE(), INTERVAL offset DAY ) INTO appointmentDate;
	RETURN appointmentDate;
END $$
DELIMITER ;
/**************************************************************/
/**************************************************************/
/**************************************************************/
DROP PROCEDURE IF EXISTS insertAppointmentsForTheCurrentWeek;
DELIMITER $$
CREATE PROCEDURE insertAppointmentsForTheCurrentWeek()
BEGIN
	DECLARE patientID INTEGER DEFAULT 0;
	DECLARE doctorID INTEGER;
	DECLARE entryTime TIME;
	DECLARE appointmentDate DATE;
	
	DECLARE currentDayIndex INTEGER DEFAULT 0;
	DECLARE currentDateNumber INTEGER DEFAULT 0;
	DECLARE daysCount INTEGER DEFAULT 7;
	
	theLoop: LOOP
		SELECT getPatientWithNonInsurance( (SELECT patientID) ) INTO patientID;
		
		SELECT getDoctorIDBasedOnADayNameIndex( getDayNameIndex( (SELECT currentDayIndex) ) ) INTO doctorID;
		SELECT currentDayIndex + 1 INTO currentDayIndex;
		
		SELECT getDoctorEntryTimeWithID( (SELECT doctorID) ) INTO entryTime;
		
		SELECT getAppointmentDate( (SELECT currentDateNumber) ) INTO appointmentDate;
		SELECT currentDateNumber + 1 INTO currentDateNumber;
		
		INSERT INTO
			turnos
		VALUES
		( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '00:00:00' ), (SELECT doctorID), (SELECT patientID), 'esperando' ),
		( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '00:15:00' ), (SELECT doctorID), (SELECT patientID), 'esperando' ),
		( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '00:30:00' ), (SELECT doctorID), (SELECT patientID), 'esperando' ),
		( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '00:45:00' ), (SELECT doctorID), (SELECT patientID), 'esperando' ),
		( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '01:00:00' ), (SELECT doctorID), (SELECT patientID), 'esperando' ),
		( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '01:15:00' ), (SELECT doctorID), (SELECT patientID), 'esperando' ),
		( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '01:30:00' ), (SELECT doctorID), (SELECT patientID), 'esperando' ),
		( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '01:45:00' ), (SELECT doctorID), (SELECT patientID), 'esperando' ),
		( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '02:00:00' ), (SELECT doctorID), (SELECT patientID), 'esperando' ),
		( null, (SELECT appointmentDate), ADDTIME( (SELECT entryTime), '02:15:00' ), (SELECT doctorID), (SELECT patientID), 'esperando' )
		;
		
		SELECT daysCount - 1 INTO daysCount;
		IF daysCount <= 0 THEN
			LEAVE theLoop;
		END IF;
		
	END LOOP theLoop;
END$$
DELIMITER ;
/**************************************************************/
/**************************************************************/
/**************************************************************/
CALL insertAppointmentsForTheCurrentWeek();