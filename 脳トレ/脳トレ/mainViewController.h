//
//  mainViewController.h
//  脳トレ
//
//  Created by g-2015 on 2013/08/24.
//  Copyright (c) 2013年 g-2015. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <AVFoundation/AVFoundation.h>
#import <AudioToolbox/AudioToolbox.h>

@interface mainViewController : UIViewController{
    int point;      //ポイント
    int topicflag1; //同じか違うかを分ける
    int topicflag2; //漢字か形か色かを分ける
    int topicColor_gra;//topicflag2で色を選択したときに、形か漢字を決める
    int topicNumber;//お題(topicflag2との組み合わせで正解を決める、色の１番のように)
    int timerCount; //表示する時間
    int correctCount;   //正解数を数える
    int inCorrectCount; //不正解数を数える
    //int selectBtn;  //
    int answerTimerCount;   //○×を消すカウントをする
    
    NSTimer *timer; //1秒をはかる
    NSTimer *answerTimer;   //○×の表示に使う
    UIImage *graphicImage[4];   //形のimage
    UIImage *kanjiImage[4];     //漢字のimage
    UIImage *answerImage[2];    //○×のimage
    UIImage *countDown[3];      //カウント(3,2,1)のimage
    UIColor *color[4];          //色を入れておく
    NSString *topicflag1String[2];  //「同じ」か「違う」が入る
    NSString *topicflag2String[3];  //「形」「漢字」「いろ」が入る
    SystemSoundID answerSe[2];  //正解時、不正解時のSE
    SystemSoundID timeSe;       //始まりのカウント、終わり間際のカウントに使うSE
    SystemSoundID startAndStopSe;   //タイトルで使うSE
    
    __weak IBOutlet UIImageView *topicView; //お題のimageView
    __weak IBOutlet UIButton *btn1;
    __weak IBOutlet UIImageView *btnImageView1;
    __weak IBOutlet UIButton *btn2;
    __weak IBOutlet UIImageView *btnImageView2;
    __weak IBOutlet UIButton *btn3;
    __weak IBOutlet UIImageView *btnImageView3;
    __weak IBOutlet UIButton *btn4;
    __weak IBOutlet UIImageView *btnImageView4;
    __weak IBOutlet UILabel *topicLabel1;   //お題の同じか違うのラベル
    __weak IBOutlet UILabel *topicLabel2;   //お題の形か漢字か色のラベル
    __weak IBOutlet UILabel *timerLabel;    //残り時間のラベル
    __weak IBOutlet UIImageView *answerLabel;   //○か×を表示するview(名前間違った)
}
@property BOOL seOnOff;
@property int maxPoint; //最高得点
- (void)makeTopic;
- (void)timerAction;
- (void)answerTimerAction;
- (void)answerImageDisplay;
- (IBAction)btn1Action:(id)sender;
- (IBAction)btn2Action:(id)sender;
- (IBAction)btn3Action:(id)sender;
- (IBAction)btn4Action:(id)sender;
- (IBAction)titleBtnAction:(id)sender;

@end
