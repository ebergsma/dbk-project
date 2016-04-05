SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `gemaakte_berekeningen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` text NOT NULL,
  `omzet` int(11) NOT NULL,
  `marge` int(11) NOT NULL,
  `marketing_budget_percentage` float NOT NULL,
  `marketing_budget_bedrag` float NOT NULL,
  `bestel_waarde` int(11) NOT NULL,
  `conversie` int(11) NOT NULL,
  `benodigde_bestellingen` int(11) NOT NULL,
  `percentage_samen` float NOT NULL,
  `betaald_bezoek` float NOT NULL,
  `bezoekers_kopen` float NOT NULL,
  `totaal_zoekvolume` float NOT NULL,
  `totaal_cpc` float NOT NULL,
  `cpc_euros` float NOT NULL,
  `cpc` float NOT NULL,
  `direct` int(11) DEFAULT NULL,
  `google` int(11) DEFAULT NULL,
  `adwords` int(11) DEFAULT NULL,
  `vw_betaald` int(11) DEFAULT NULL,
  `vw_onbetaald` int(11) DEFAULT NULL,
  `overig` int(11) DEFAULT NULL,
  `bezoekers` int(11) NOT NULL,
  `zoekterm1` text,
  `zoekterm2` text,
  `zoekterm3` text,
  `zoekterm4` text,
  `zoekterm5` text,
  `session_id` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=99 ;

CREATE TABLE IF NOT EXISTS `niewsbrief_aanmeldingen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(256) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `zoekwoorden` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `woord` varchar(64) NOT NULL,
  `cpc` int(11) NOT NULL,
  `volume` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;
