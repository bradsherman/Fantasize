(SELECT player, Team, opponent, ranking, Projection, Position, @cur := @cur + 1 as finalRating
FROM
(
SELECT player, tm as Team, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player, tm, pos
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos
FROM OffensiveStats
) A
GROUP BY player
) B, 
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemOffensive, math, schedule, userTeams
WHERE userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ?  and pos = 'QB' and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
) L, (SELECT @cur := 0) w
LIMIT 1
) UNION ALL
(
SELECT player, Team, opponent, ranking, Projection, Position, @cur2 := @cur2 + 1 as finalRating
FROM
(
SELECT player, tm as Team, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player, tm, pos
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos
FROM OffensiveStats
) A
GROUP BY player
) B, 
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemOffensive, math, schedule, userTeams
WHERE userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ?  and pos = 'WR' and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15) and schedule.team = tm
GROUP BY player
ORDER BY Projection DESC
) L, (SELECT @cur2 := 0) w
LIMIT 2
) UNION ALL
(
SELECT player, Team, opponent, ranking, Projection, Position, @cur3 := @cur3 + 1 as finalRating
FROM
(
SELECT player, tm as Team, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player, tm, pos
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos
FROM OffensiveStats
) A
GROUP BY player
) B, 
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemOffensive, math, schedule, userTeams
WHERE userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ?  and pos = 'RB' and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15) and schedule.team = tm
GROUP BY player
ORDER BY Projection DESC
) L, (SELECT @cur3 := 0) w
LIMIT 2
) UNION ALL 
(
SELECT player, Team, opponent, ranking, Projection, Position, @cur4 := @cur4 + 1 as finalRating
FROM
(
SELECT player, tm as Team, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player, tm, pos
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos
FROM OffensiveStats
) A
GROUP BY player
) B, 
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemOffensive, math, schedule, userTeams
WHERE userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ?  and pos = 'TE' and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
) L, (SELECT @cur4 := 0) w
LIMIT 1
) UNION ALL

(

SELECT ZZ.player, ZZ.Team, ZZ.opponent, ZZ.ranking, ZZ.Projection, ZZ.Position, ZZ.finalRating
FROM 

(

(	
SELECT player, Team, opponent, ranking, Projection, Position, finalRating
FROM
(
SELECT player, Team, opponent, ranking, Projection, Position, @cur6 := @cur6 + 1 as finalRating
FROM
(
SELECT player, tm as Team, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player, tm, pos
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos
FROM OffensiveStats
) A
GROUP BY player
) B, 
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemOffensive, math, schedule, userTeams
WHERE userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ?  and (pos = 'TE') and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
) L, (SELECT @cur6 := 0) w
) Z
WHERE finalRating = 2
) UNION ALL
(
SELECT player, Team, opponent, ranking, Projection, Position, finalRating
FROM
(
SELECT player, Team, opponent, ranking, Projection, Position, @cur7 := @cur7 + 1 as finalRating
FROM
(
SELECT player, tm as Team, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player, tm, pos
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos
FROM OffensiveStats
) A
GROUP BY player
) B, 
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemOffensive, math, schedule, userTeams
WHERE userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ?  and (pos = 'WR') and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
) L, (SELECT @cur7 := 0) w
) a
WHERE finalRating = 3
) UNION ALL 
(
SELECT player, Team, opponent, ranking, Projection, Position, finalRating
FROM
(
SELECT player, Team, opponent, ranking, Projection, Position, @cur8 := @cur8 + 1 as finalRating
FROM
(
SELECT player, tm as Team, def as opponent, ranking, ROUND(((receptions * ScoringSystemOffensive.rec + reYd / ScoringSystemOffensive.recYdPt + reTD * ScoringSystemOffensive.recTD + fm * 
ScoringSystemOffensive.fumbLost + pYd / ScoringSystemOffensive.passYdPt + pTD * ScoringSystemOffensive.passTD + 
inter * ScoringSystemOffensive.passINT + ruYd / ScoringSystemOffensive.rushYdPt + ruTD * ScoringSystemOffensive.rushTD
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, pos as Position
FROM
(
SELECT (SUM(recYds * week) / SUM(week)) as reYd, (SUM(recTD * week) / SUM(week)) as reTD, (SUM(fumLost * week) / SUM(week)) as fm, (SUM(rec * week) / SUM(week)) as receptions,
(SUM(passYds * week) / SUM(week)) as pYd, (SUM(passTD * week) / SUM(week)) as pTD, (SUM(interception * week) / SUM(week)) as inter, (SUM(rushYds * week) / SUM(week)) as ruYd, (SUM(rushTD * week) 
/ SUM(week)) as ruTD, player, tm, pos
FROM
(
SELECT passYds, passTD, interception, rushYds, rushTD, recYds, week, recTD, fumLost, player, team as tm, rec, pos
FROM OffensiveStats
) A
GROUP BY player
) B, 
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemOffensive, math, schedule, userTeams
WHERE userTeams.teamName = ? and ScoringSystemOffensive.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ?  and (pos = 'RB') and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
) L, (SELECT @cur8 := 0) w
) i
WHERE finalRating  = 3
)
ORDER BY Projection DESC
) ZZ LIMIT 1
)
UNION ALL
(
SELECT player, tm as Team, '--', '--', ROUND(p, 2) as Projection, 'K', '--'
FROM
(
SELECT (SUM(standPts * week) / SUM(week)) as p, player, tm
FROM
(
SELECT player, week, team as tm, opp, standPts
FROM KickingStats
) A
GROUP BY player
) B, schedule, userTeams
WHERE userTeams.teamName = ? and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
LIMIT 1
)
UNION ALL
(
SELECT player, tm as Team, def as opponent, ranking, ROUND(((sa * ScoringSystemDST.sack + inter * ScoringSystemDST.interceptions + fm * 
ScoringSystemDST.fumb + saf * ScoringSystemDST.safety + dTD * ScoringSystemDST.defTD + rTD * ScoringSystemDST.retTD + ptsAll
)*(math.one - (val - ranking)*math.multiplier))
, 2) as Projection, 'DST', '--'
FROM
( 
SELECT CASE
WHEN pts = 0
THEN ScoringSystemDST.pt0
WHEN pts < 7 and pts > 0
THEN ScoringSystemDST.pt16
WHEN pts < 14 and pts > 6
THEN ScoringSystemDST.pt713
WHEN pts < 21 and pts > 13
THEN ScoringSystemDST.pt1420
WHEN pts < 28 and pts > 20
THEN ScoringSystemDST.pt2127
WHEN pts < 35 and pts > 27
THEN ScoringSystemDST.pt2834
ELSE ScoringSystemDST.pt35
END AS ptsAll, sa, inter, fm, saf, dTD, rTD, pts, player, tm
FROM
(
SELECT (SUM(sacks * week) / SUM(week)) as sa, (SUM(interceptions * week) / SUM(week)) as inter, (SUM(fumRec * week) / SUM(week)) as fm, (SUM(safety * week) / SUM(week)) as saf,
(SUM(defTD * week) / SUM(week)) as dTD, (SUM(returnTD * week) / SUM(week)) as rTD, (SUM(ptsAllowed * week) / SUM(week)) as pts, player, tm
FROM
(
SELECT player, week, team as tm, opp, sacks, interceptions, fumRec, safety, defTD, returnTD, ptsAllowed
FROM DSTStats
) A
GROUP BY player
) B, ScoringSystemDST
WHERE ScoringSystemDST.name = 'Standard'
) Q,
(
SELECT  k, def, @curRank := @curRank + 1 AS ranking, team as defense, week
FROM
(
SELECT (SUM(ptsAllowed)/COUNT(week)) as k, player as def, team, week
FROM
(
SELECT player, ptsAllowed, week, team
FROM DSTStats
WHERE pos = 'DST'
) A
GROUP BY player
) B, (SELECT @curRank := 0) r
ORDER BY k
) D, ScoringSystemDST, math, schedule, userTeams
WHERE userTeams.teamName = ? and ScoringSystemDST.name = 'Standard' and math.multiplier = 0.015 and math.one = 1 and defense = ? and schedule.team = tm and (player = userTeams.p1 or player = userTeams.p2 or player = userTeams.p3 or player = userTeams.p4 or player = userTeams.p5 or player = userTeams.p6 or player = userTeams.p7 or player = userTeams.p8 or player = userTeams.p9 or player = userTeams.p10 or player = userTeams.p11 or player = userTeams.p12 or player = userTeams.p13 or player = userTeams.p14 or player = userTeams.p15)
GROUP BY player
ORDER BY Projection DESC
LIMIT 1
)
;