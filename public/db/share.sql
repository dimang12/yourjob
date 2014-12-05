CREATE TABLE IF NOT EXISTS `share` (
`share_id` int(11) NOT NULL,
  `shar_title` varchar(200) NOT NULL,
  `shar_detail` text NOT NULL,
  `shar_post_by` varchar(150) NOT NULL,
  `shar_contact` varchar(250) NOT NULL,
  `shar_post_date` date NOT NULL,
  `shar_start_date` date NOT NULL,
  `shar_close_date` date NOT NULL,
  `shar_img` varchar(100) NOT NULL,
  `shar_approval` int(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;
