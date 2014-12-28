-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 28, 2014 at 05:10 AM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ourjob`
--

-- --------------------------------------------------------

--
-- Table structure for table `share`
--

CREATE TABLE IF NOT EXISTS `share` (
`share_id` int(11) NOT NULL,
  `shar_title` varchar(200) NOT NULL,
  `shar_detail` text NOT NULL,
  `shar_post_by` varchar(150) NOT NULL,
  `shar_contact` varchar(250) NOT NULL,
  `shar_address` varchar(100) NOT NULL,
  `shar_phone` varchar(20) NOT NULL,
  `shar_email` varchar(50) NOT NULL,
  `shar_website` varchar(80) NOT NULL,
  `shar_post_date` date NOT NULL,
  `shar_img` varchar(100) NOT NULL,
  `shar_approval` int(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `share`
--

INSERT INTO `share` (`share_id`, `shar_title`, `shar_detail`, `shar_post_by`, `shar_contact`, `shar_address`, `shar_phone`, `shar_email`, `shar_website`, `shar_post_date`, `shar_img`, `shar_approval`) VALUES
(1, 'acb', 'sdfsdf', 'abc', 'abc', '', '', '', '', '2014-12-10', '5487ef4d6f874.jpg', 1),
(2, 'How to interview', 'How to interview detail<br>', 'Mr. Chine', 'Phnom Penh', '', '', '', '', '2014-12-10', '548803e9d420c.jpg', 1),
(3, 'How to apply a new job ?', 'this is a description of how to apply a new job<br>', 'Mr. Chine', '', 'Tul Svay Prey, Phnom Penh', '012 999 988', 'tue.chine@gmail.com', 'www.youjob.inof', '2014-12-10', '54881062a7a5d.jpg', 1),
(4, 'Documents That You May Need to Apply for Jobs', '<div>Supporting documents are the documents that may be be required when applying for a job.</div>\r\n\r\n\r\n				<span>Supporting documents for a job application may include a resume, a cover letter, your transcript, a <a rel="" target="" href="http://jobsearch.about.com/od/jobapplications/qt/writing-samples.htm">writing sample</a>,\r\n Veterans'' Preference documents, portfolios, certifications, a reference\r\n list, letters of recommendation, employment certificate, and other \r\nsupporting documentation as specified in the job posting.</span>\r\n\r\n\r\n				<span>When applying for jobs, be sure to upload or send all the \r\nrequested supporting documents in the format requested in the job \r\nlisting.<br><br></span><br>If the company requests that supporting documentation be brought to \r\nthe interview, bring a photocopy of each of the requested documents with\r\n you for the hiring manager.\r\n\r\n\r\n				Supporting Documents\r\n\r\n\r\n				The following is a list of supporting documents that may be required to be submitted with an employment application.<br>', 'CHOU Dimang', '', 'Tul Svay Prey, Phnom Penh', '012 952 975', 'dimang12@gmail.com', 'www.youjob.inof', '2014-12-27', '549dfc41020e6.jpg', 1),
(5, 'Top 10 Ways to Get a Better Job', 'So your job sucks. You could resign yourself to a life of dull (or even \r\nmiserable) days in the office or you could set aside some time and get a\r\n better job. Here are ten great tips to help you put together a great \r\napplication, ace the interview, and ultimately work for a company you''ll\r\n love rather than hate. <br><br><br>While I''m no fan of the resume—as they''re often documents skimmed rather\r\n than read—they''re still requested by the majority of jobs you''ll come \r\nacross. You don''t want to reinvent the wheel, but a little creativity \r\ncan set you apart and help you stand out from the pool. Online tools can\r\n be of great help when it comes to creating something a little less \r\nordinary. <a rel="" target="_blank" href="http://vizualize.me/">Visualize.me</a> can create an attractive infographic. Sites like <a rel="" target="_blank" href="http://re.vu/">Re.vu</a> and <a rel="" target="_blank" href="http://zerply.com/">Zerply</a> help you create professional landing pages that can serve as digital resumes. <a rel="" target="_blank" href="http://about.me">About.me</a> and <a rel="" target="_blank" href="http://flavors.me/">Flavors.me</a> can be tailored to do the same. Use the tool that suits you best and <a rel="" target="" href="http://lifehacker.com/5886755/how-to-make-your-personal-or-professional-landing-page-stand-out/gallery/1">make sure your page or resume stands out</a>. Often times it is just as simple as <a rel="" target="" href="http://lifehacker.com/5801255/choose-the-best-font-and-color-for-your-message">choosing the right font and color</a>.\r\n It doesn''t take much to make a resume look nice, so put in that little \r\nadditional effort to keep yours from ending up in the generic pile.<br><br>', 'CHOU Dimang', '', 'Tul Svay Prey, Phnom Penh', '012 999 988', 'dimang12@gmail.com', 'www.youjob.inof', '2014-12-27', '549e0079b5450.jpg', 1),
(6, 'How to Get a Job', 'Before you start job hunting, make sure that your resume is as complete \r\nand up-to-date as possible. Your resume is an important distillation of \r\nwho you are, where you come from, and what you can offer. Here are a few\r\n tips to consider:\r\n<ul><li>Never make up information on a resume; it can come back to haunt you later.</li><li>Look at a variety of recent, relevant job descriptions. Use similar \r\nlanguage to describe your skills and accomplishments on your own resume.</li><li>Use active verbs. When describing what you did at your last job, make the sentence as tight and active as possible.</li><li>Proofread. Review your resume several times for grammatical or \r\nspelling errors. Even something as simple as a typo could negatively \r\nimpact your ability to land an interview, so pay close attention to what\r\n you''ve left on the page. Have one or two other people look at it as \r\nwell.</li><li>Keep the formatting classic and to the point. How your resume looks \r\nis almost as important as how it reads. Use a simple font (such as Times\r\n New Roman, Arial or Bevan), black ink on white or ivory colored paper, \r\nand wide margins (about 1" on each side). Avoid bold or italic \r\nlettering. Ensure your name and contact information are clearly and \r\nprominently displayed.</li></ul><br>', 'CHOU Dimang', '', 'Tul Svay Prey, Phnom Penh', '012 952 975', 'dimang12@gmail.com', 'www.youjob.inof', '2014-12-27', '549e324199f84.jpg', 1),
(7, 'Prepare for job interview', 'Many structured interviews, particularly those at large companies, start\r\n with a question like "Tell me about yourself." The interviewer doesn''t \r\nwant to hear about grade school or growing up. This is a work and \r\nexperience related question with a right answer: in two minutes or so, \r\nthe interviewer wants to understand your background, your \r\naccomplishments, why you want to work at this company and what your \r\nfuture goals are.\r\n<ul><li>Keep it brief — between 30 seconds and two minutes — and have the \r\nbasics of it memorized so that you don''t stammer when you''re asked to \r\ndescribe yourself. You don''t want to sound like recording or a robot, \r\neither, so only get the structure of it down, and learn to improvise the\r\n rest depending on who you''re talking to. Practice your elevator pitch \r\nout loud on someone who can give you feedback.</li><li>An elevator pitch is also useful for when you''re networking, at a \r\nparty or anywhere with a group of strangers who want to get to know you a\r\n little bit more. In a networking situation, as opposed to a job \r\ninterview, keep the elevator pitch to 30 seconds or less.</li></ul><br>', 'CHOU Dimang', '', 'Tul Svay Prey, Phnom Penh', '012 952 975', 'dimang12@gmail.com', 'www.youjob.inof', '2014-12-27', '549e3287ad13b.jpg', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `share`
--
ALTER TABLE `share`
 ADD PRIMARY KEY (`share_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `share`
--
ALTER TABLE `share`
MODIFY `share_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
