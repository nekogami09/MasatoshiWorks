//
//  mainViewController.m
//  脳トレ
//
//  Created by g-2015 on 2013/08/24.
//  Copyright (c) 2013年 g-2015. All rights reserved.
//

#import "mainViewController.h"
#import "clearViewController.h"
#import "ViewController.h"

@interface mainViewController ()

@end

@implementation mainViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

//はじめのロード
- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    //画像の読み込み&色の読み込み
    graphicImage[0] = [UIImage imageNamed:@"circle.png"];
    graphicImage[1] = [UIImage imageNamed:@"heart.png"];
    graphicImage[2] = [UIImage imageNamed:@"Square.png"];
    graphicImage[3] = [UIImage imageNamed:@"start.png"];
    kanjiImage[0] = [UIImage imageNamed:@"red2.png"];
    kanjiImage[1] = [UIImage imageNamed:@"green2.png"];
    kanjiImage[2] = [UIImage imageNamed:@"yellow2.png"];
    kanjiImage[3] = [UIImage imageNamed:@"blue2.png"];
    answerImage[0] = [UIImage imageNamed:@"correctAnswer.png"];
    answerImage[1] = [UIImage imageNamed:@"incorrectAnswer.png"];
    countDown[0] = [UIImage imageNamed:@"1.png"];
    countDown[1] = [UIImage imageNamed:@"2.png"];
    countDown[2] = [UIImage imageNamed:@"3.png"];
    color[0] = [UIColor redColor];
    color[1] = [UIColor blueColor];
    color[2] = [UIColor greenColor];
    color[3] = [UIColor yellowColor];
    topicflag1String[0] = @"同じ";
    topicflag1String[1] = @"違う";
    topicflag2String[0] = @"形";
    topicflag2String[1] = @"漢字";
    topicflag2String[2] = @"色";
    
    //音
    NSString *soundPath = [[NSBundle mainBundle] pathForResource:@"nc1281" ofType:@"wav"];
    NSURL *soundUrl = [NSURL fileURLWithPath:soundPath];
    AudioServicesCreateSystemSoundID((__bridge CFURLRef)soundUrl, &answerSe[0]);
    soundPath = [[NSBundle mainBundle] pathForResource:@"nc1280" ofType:@"wav"];
    soundUrl = [NSURL fileURLWithPath:soundPath];
    AudioServicesCreateSystemSoundID((__bridge CFURLRef)soundUrl, &answerSe[1]);
    
    soundPath = [[NSBundle mainBundle] pathForResource:@"timeSe2" ofType:@"wav"];
    soundUrl = [NSURL fileURLWithPath:soundPath];
     AudioServicesCreateSystemSoundID((__bridge CFURLRef)soundUrl, &timeSe);
    soundPath = [[NSBundle mainBundle] pathForResource:@"dora" ofType:@"wav"];
    soundUrl = [NSURL fileURLWithPath:soundPath];
    AudioServicesCreateSystemSoundID((__bridge CFURLRef)soundUrl, &startAndStopSe);
    
    
    
    //初期化
    point = 0;
    topicflag1 = 0;
    topicflag2 = 0;
    topicColor_gra = 0;
    topicNumber = 0;
    timerCount = 34;
    //timerCount = 4;
    correctCount = 0;
    inCorrectCount = 0;
    //selectBtn = 0;
    answerTimerCount = 0;
       
    //○×
    answerLabel.image = answerImage[0];
    answerLabel.alpha = 0;
    answerLabel.frame = CGRectMake(40, 220, 240, 240);
    timerLabel.text = @"30";
    
    //タイマーを作動させる
    timer = [NSTimer scheduledTimerWithTimeInterval:1.0
                                             target:self selector:@selector(timerAction)
                                           userInfo:nil
                                            repeats:YES];

    
    [self makeTopic];   //お題をつくる
    
    //はじめの３秒はボタンを押せなくする
    btn1.hidden = YES;
    btn2.hidden = YES;
    btn3.hidden = YES;
    btn4.hidden = YES;
    
    NSLog(@"_seOnOff,%d", _seOnOff);
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

//お題をつくる
- (void)makeTopic{
    //お題を決める
    int ra = arc4random() % 10;  //同じ：違う＝9：１
    if(ra == 0){
        topicflag1 = 1;
    }else{
        topicflag1 = 0;
    }
    topicflag2 = arc4random() % 3;
    topicColor_gra = arc4random() % 2;
    topicNumber = arc4random() % 4;
    //お題の表示
    switch (topicflag2) {
        case 0:
            topicView.image = graphicImage[topicNumber];
            topicView.backgroundColor = color[arc4random()%4];
            break;
        case 1:
            topicView.image = kanjiImage[topicNumber];
            topicView.backgroundColor = color[arc4random()%4];
            break;
        case 2:
            topicView.backgroundColor = color[topicNumber];
            if(topicColor_gra == 0){
                topicView.image = graphicImage[arc4random()%4];
            }else{
                topicView.image = kanjiImage[arc4random()%4];
            }
        default:
            break;
    }
    topicLabel1.text = topicflag1String[topicflag1];
    topicLabel2.text = topicflag2String[topicflag2];
    
    //ボタンの表示
    
    int random[4] = {0, 1, 2, 3};
    for(int i = 0; i < 4; i ++){    //ランダムの生成
        int x = arc4random() % 4;
        int tmp = random[i];
        random[i] = random[x];
        random[x] = tmp;
    }
    btnImageView1.backgroundColor = color[random[0]];
    btnImageView2.backgroundColor = color[random[1]];
    btnImageView3.backgroundColor = color[random[2]];
    btnImageView4.backgroundColor = color[random[3]];
    for(int i = 0; i < 4; i ++){
        int x = arc4random() % 4;
        int tmp = random[i];
        random[i] = random[x];
        random[x] = tmp;
    }
    if(topicflag2 == 0 || (topicflag2 == 2 && topicColor_gra == 0)){    //形＋色
        btnImageView1.image = graphicImage[random[0]];
        btnImageView2.image = graphicImage[random[1]];
        btnImageView3.image = graphicImage[random[2]];
        btnImageView4.image = graphicImage[random[3]];
    }else{  //漢字＋色
        btnImageView1.image = kanjiImage[random[0]];
        btnImageView2.image = kanjiImage[random[1]];
        btnImageView3.image = kanjiImage[random[2]];
        btnImageView4.image = kanjiImage[random[3]];
    }
}

//○か×の表示に呼ばれる
- (void)answerImageDisplay{
    if(point < 0) point = 0; //ポイントをマイナスにしない
    answerLabel.alpha = 1.0;
    answerLabel.frame = CGRectMake(40, 220, 240, 240);
    [answerTimer invalidate];   //answerTimerを一回止めて新しくする
    answerTimerCount = 0;
    answerTimer = [NSTimer scheduledTimerWithTimeInterval:0.01
                                                   target:self selector:@selector(answerTimerAction)
                                                 userInfo:nil
                                                  repeats:YES];
    NSLog(@"%d", point);
}

//1.0秒したら○か×を消す
- (void)answerTimerAction{  //answerTimerで0.01秒ごとに呼ばれる
    answerTimerCount++;     //
    NSLog(@"answerTImerCount,%d", answerTimerCount);
    if(answerTimerCount > 100){  //カウント100になったら消す(1.0秒)
        answerLabel.alpha = 0;  //見えなくする
        answerLabel.frame = CGRectMake(40, 220, 240, 240);  //元の大きさに戻す
        answerTimerCount--; //カウントが進まないようにする
    }else{
        //○×のサイズをカウントにつれて大きさをかえる
        if(answerTimerCount > 50 && answerTimerCount <= 75){
            int answerTimerCountbig = answerTimerCount - 50;
            answerLabel.frame = CGRectMake(40-(answerTimerCountbig*3), 220-(answerTimerCountbig*3), 240+answerTimerCountbig*6, 240+answerTimerCountbig*6);
        }else if(answerTimerCount > 75){
            float ax = 40 - 75;
            float ay = 220 - 75;
            float aw = 240 + 150;
            float ah = 240 + 150;
            int answerTimerCountsmoll = answerTimerCount - 75;
            answerLabel.frame = CGRectMake(ax+(answerTimerCountsmoll*4), ay+(answerTimerCountsmoll*4), aw-answerTimerCountsmoll*8, ah-answerTimerCountsmoll*8);
        }
        
        //カウント50まではゆっくり薄くなり、それ以降は一気に薄くなる
        float answerTimerCountFloat = answerTimerCount; //float型にする
        //answerLabel.alpha = 1.0 - (answerTimerCountFloat / 100.0);
        if(answerTimerCount <= 50){
            answerLabel.alpha = 1.0 - (answerTimerCountFloat / 200.0);
        }else{
            answerLabel.alpha = 0.75 - ((answerTimerCountFloat-50) / (50/0.75));
        }
        
    }
    
}

- (IBAction)btn1Action:(id)sender {
    //判定
    if(topicflag2 != 2){    //形か漢字の時の判定
        if((topicView.image == btnImageView1.image && topicflag1 == 0)
           || (topicView.image != btnImageView1.image && topicflag1 == 1)){ //正解
            point++;    //ポイントを足す
            correctCount++; //正解数を足す
            answerLabel.image = answerImage[0]; //○を表示
            [self answerImageDisplay];  //表示して消す
            if(_seOnOff) AudioServicesPlaySystemSound(answerSe[0]);  //アンサー音
        }else{  //不正解
            point -= 2; //ポイントを減らす
            inCorrectCount++;   //不正解数を足す
            answerLabel.image = answerImage[1]; //×を表示
            [self answerImageDisplay];  //表示して消す
            if(_seOnOff) AudioServicesPlaySystemSound(answerSe[1]);  //アンサー音
        }
    }else{  //色のときの判定
        if((topicView.backgroundColor == btnImageView1.backgroundColor && topicflag1 == 0)
           || (topicView.backgroundColor != btnImageView1.backgroundColor && topicflag1 == 1)){ //正解
            point++;     //ポイントを足す
            correctCount++; //正解数を足す
            answerLabel.image = answerImage[0]; //○を表示
            [self answerImageDisplay];  //表示して消す
            if(_seOnOff) AudioServicesPlaySystemSound(answerSe[0]);  //アンサー音
        }else{  //不正解
            point -=2;//ポイントを減らす
            inCorrectCount++;   //不正解数を足す
            answerLabel.image = answerImage[1]; //×を表示
            [self answerImageDisplay];  //表示して消す
            if(_seOnOff) AudioServicesPlaySystemSound(answerSe[1]);  //アンサー音
        }
    }
    [self makeTopic];
}

- (IBAction)btn2Action:(id)sender {
    //判定
    if(topicflag2 != 2){    //形か漢字の時の判定
        if((topicView.image == btnImageView2.image && topicflag1 == 0)
           || (topicView.image != btnImageView2.image && topicflag1 == 1)){ //正解
            point++;    //ポイントを足す
            correctCount++; //正解数を足す
            answerLabel.image = answerImage[0]; //○を表示
            [self answerImageDisplay];  //表示して消す
            if(_seOnOff) AudioServicesPlaySystemSound(answerSe[0]);  //アンサー音
        }else{  //不正解
            point -= 2; //ポイントを減らす
            inCorrectCount++;   //不正解数を足す
            answerLabel.image = answerImage[1]; //×を表示
            [self answerImageDisplay];  //表示して消す
            if(_seOnOff) AudioServicesPlaySystemSound(answerSe[1]);  //アンサー音
        }
    }else{  //色のときの判定
        if((topicView.backgroundColor == btnImageView2.backgroundColor && topicflag1 == 0)
           || (topicView.backgroundColor != btnImageView2.backgroundColor && topicflag1 == 1)){ //正解
            point++;     //ポイントを足す
            correctCount++; //正解数を足す
            answerLabel.image = answerImage[0]; //○を表示
            [self answerImageDisplay];  //表示して消す
            if(_seOnOff) AudioServicesPlaySystemSound(answerSe[0]);  //アンサー音
        }else{  //不正解
            point -=2;//ポイントを減らす
            inCorrectCount++;   //不正解数を足す
            answerLabel.image = answerImage[1]; //×を表示
            [self answerImageDisplay];  //表示して消す
            if(_seOnOff) AudioServicesPlaySystemSound(answerSe[1]);  //アンサー音
        }
    }
    [self makeTopic];

}

- (IBAction)btn3Action:(id)sender {
    //判定
    if(topicflag2 != 2){    //形か漢字の時の判定
        if((topicView.image == btnImageView3.image && topicflag1 == 0)
           || (topicView.image != btnImageView3.image && topicflag1 == 1)){ //正解
            point++;    //ポイントを足す
            correctCount++; //正解数を足す
            answerLabel.image = answerImage[0]; //○を表示
            [self answerImageDisplay];  //表示して消す
            if(_seOnOff) AudioServicesPlaySystemSound(answerSe[0]);  //アンサー音
        }else{  //不正解
            point -= 2; //ポイントを減らす
            inCorrectCount++;   //不正解数を足す
            answerLabel.image = answerImage[1]; //×を表示
            [self answerImageDisplay];  //表示して消す
            if(_seOnOff) AudioServicesPlaySystemSound(answerSe[1]);  //アンサー音
        }
    }else{  //色のときの判定
        if((topicView.backgroundColor == btnImageView3.backgroundColor && topicflag1 == 0)
           || (topicView.backgroundColor != btnImageView3.backgroundColor && topicflag1 == 1)){ //正解
            point++;     //ポイントを足す
            correctCount++; //正解数を足す
            answerLabel.image = answerImage[0]; //○を表示
            [self answerImageDisplay];  //表示して消す
            if(_seOnOff) AudioServicesPlaySystemSound(answerSe[0]);  //アンサー音
        }else{  //不正解
            point -=2;//ポイントを減らす
            inCorrectCount++;   //不正解数を足す
            answerLabel.image = answerImage[1]; //×を表示
            [self answerImageDisplay];  //表示して消す
            if(_seOnOff) AudioServicesPlaySystemSound(answerSe[1]);  //アンサー音
        }
    }
    [self makeTopic];
}

- (IBAction)btn4Action:(id)sender {
    //判定
    if(topicflag2 != 2){    //形か漢字の時の判定
        if((topicView.image == btnImageView4.image && topicflag1 == 0)
           || (topicView.image != btnImageView4.image && topicflag1 == 1)){ //正解
            point++;    //ポイントを足す
            correctCount++; //正解数を足す
            answerLabel.image = answerImage[0]; //○を表示
            [self answerImageDisplay];  //表示して消す
            if(_seOnOff) AudioServicesPlaySystemSound(answerSe[0]);  //アンサー音
        }else{  //不正解
            point -= 2; //ポイントを減らす
            inCorrectCount++;   //不正解数を足す
            answerLabel.image = answerImage[1]; //×を表示
            [self answerImageDisplay];  //表示して消す
            if(_seOnOff) AudioServicesPlaySystemSound(answerSe[1]);  //アンサー音
        }
    }else{  //色のときの判定
        if((topicView.backgroundColor == btnImageView4.backgroundColor && topicflag1 == 0)
           || (topicView.backgroundColor != btnImageView4.backgroundColor && topicflag1 == 1)){ //正解
            point++;     //ポイントを足す
            correctCount++; //正解数を足す
            answerLabel.image = answerImage[0]; //○を表示
            [self answerImageDisplay];  //表示して消す
            if(_seOnOff) AudioServicesPlaySystemSound(answerSe[0]);  //アンサー音
        }else{  //不正解
            point -=2;//ポイントを減らす
            inCorrectCount++;   //不正解数を足す
            answerLabel.image = answerImage[1]; //×を表示
            [self answerImageDisplay];  //表示して消す
            if(_seOnOff) AudioServicesPlaySystemSound(answerSe[1]);  //アンサー音
        }
    }
    [self makeTopic];
}

//1秒ごとに呼ばれる
- (void)timerAction{
    if([timer isValid]){
        timerCount--;
        if(timerCount > 30){   //30になったら始まる
            //カウントを表示
            int countDownIndex = timerCount - 31;
            answerLabel.alpha = 1;
            answerLabel.image = countDown[countDownIndex];
            
            [self makeTopic];   //お題をつくる
            if(_seOnOff) AudioServicesPlaySystemSound(timeSe);  //se
        }else if(timerCount == 30){
            answerLabel.alpha = 0;
            btn1.hidden = NO;   //ボタンを使えるようにする
            btn2.hidden = NO;
            btn3.hidden = NO;
            btn4.hidden = NO;
            if(_seOnOff) AudioServicesPlaySystemSound(startAndStopSe);   //スタート音
            [self makeTopic];   //お題をつくる
        }else{
            if(timerCount <= 5 && timerCount > 0){
               if(_seOnOff) AudioServicesPlaySystemSound(timeSe);  //5秒以下なら音を鳴らす
            }
            if(timerCount == 0){
                [timer invalidate];         //タイマーを止める
                [answerTimer invalidate];
                if(_seOnOff) AudioServicesPlaySystemSound(startAndStopSe);   //ストップ音
                [self performSegueWithIdentifier:@"clearView" sender:self]; //クリア画面へ移行
            }
            timerLabel.text = [NSString stringWithFormat:@"%d", timerCount];
        }
    }
}

- (IBAction)titleBtnAction:(id)sender {
    [timer invalidate];         //タイマーを止める
    [answerTimer invalidate];
}

//view移動したときの値渡しでつかう
-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    //Segueの特定
    if ( [[segue identifier] isEqualToString:@"clearView"] ) {  //結果画面になったら結果画面に値を渡す
        clearViewController *nextViewController = [segue destinationViewController];
        //ここで遷移先ビューのクラスの変数receiveStringに値を渡している
        nextViewController.clearTimeCount = point;         //今回のポイントを結果画面に渡す
        nextViewController.seOnOff = _seOnOff;  //サウンドのオンかオフかのフラグ
        nextViewController.clearCorrectCount = correctCount;    //正解数
        nextViewController.clearInCorrectCount = inCorrectCount;//不正解数
        nextViewController.maxPoint = _maxPoint;    //最大ポイント
    }else{  //結果画面いがい(タイトル画面)に画面が切り替わったらタイトルに値を渡す
    
    mainViewController *nextViewController = [segue destinationViewController]; 
    //ここで遷移先ビューのクラスの変数receiveStringに値を渡している
    nextViewController.seOnOff = _seOnOff;
    nextViewController.maxPoint = _maxPoint;
    }
}


@end
