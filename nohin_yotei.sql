SELECT nohin_fr_backup.date, nohin_fr_backup.tenban2, Count(nohin_fr_backup.kanri_no) AS nohin_yotei
FROM nohin_fr_backup
GROUP BY nohin_fr_backup.date, nohin_fr_backup.tenban2;
