for Y in {2020..2020}
do
  mkdir $Y
  cd $Y
  for M in {02..02}
  do
    mkdir $M
    cd $M
    for D in {24..28}
    do
      mkdir $D
      cd $D
      for i in $(seq 1 $((1 + RANDOM % 5))) 
      do
        echo "$i on $M/$D/$Y" > commit.md
        export GIT_COMMITTER_DATE="$Y-$M-$D 12:$i:00"
        export GIT_AUTHOR_DATE="$Y-$M-$D 12:$i:00"
        git add commit.md -f
        git commit --date="$Y-$M-$D 12:0$i:00" -m "$i on $M $D $Y"
      done
      cd ../
    done
    cd ../
  done
  cd ../
done
git push origin master
git rm -rf 20**
git rm -rf 19**
git commit -am "cleanup"
git push origin master